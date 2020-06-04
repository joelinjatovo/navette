<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\Item;
use App\Models\Order;
use App\Models\Ride;
use App\Models\RideItem;
use App\Models\User;
use App\Services\GoogleApiService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RideProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $google;
	
    /**
     * Create a new job instance.
     *
     * @param  Ride $ride
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GoogleApiService $google)
    {
		info('RideProcessor...');
        $this->google = $google;

		// Handle job...
		$items = Item::join('orders', 'orders.id', '=', 'items.order_id')
			->where('orders.status', Order::STATUS_OK)
			->where('items.status', Item::STATUS_PING)
			->where(function($query) {
				$query->whereNull('items.ride_at');
				$query->orWhere('items.ride_at', '<=', now()->addMinutes(30));
			})
			->distinct('items.order_id')
			->get();

		foreach($items as $item){
			$this->performTask($item);
		}
		
    }
	
    /**
     * Process this item
     *
     * @return boolean
     */
    protected function performTask(Item $item)
    {
		$ride = null;
		$order = $item->order;
		$club = $item->club;
		
		if(!$order || !$club){
			return $ride;
		}
		
		// Find the available car who has place count
		$car = $this->findPerfectCar($club, $order->place);
		if($car && $car->driver){
			$ride = $this->createRide($item, $car);
		}
		
		// Find the good car who has car_place > ordered_place
		if(!$ride){
			$car = $this->findBestCar($club, $order->place);
			if($car && $car->driver){
				$ride = $this->createRide($item, $car);
			}
		}
		
		// Find locked car who has rides.available_place = order_place
		if(!$ride){
			$ride = $this->findPerfectPingedRide($club, $order->place);
			if($ride){
				$ride->attachRide($item);
			}
		}
		
		// Find locked car who has rides.available_place > order_place
		if(!$ride){
			$ride = $this->findBestPingedRide($club, $order->place);
			if($ride){
				$ride->attachRide($item);
			}
		}
		
		return $ride;
		
		/*
		// Attach the item's order point to the ride
		$ride->attachRidePoint($item);
		$item->associateRide($ride); // Set item ride
		$item->active(); // Active item
		if($item->order){
			$item->order->active(); // Active order
		}

		$ride->verifyDirection($this->google);
		*/
			
    }
	
	private createRide(Item $item, Car $car){
		$ride = new Ride();
		$ride->status = Ride::STATUS_PING;
		$ride->driver()->associate($car->driver);
		if($ride->save()){
			$car->lock();
			return $ride;
		}
		return null;
	}
	
	private function findPerfectCar(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE);
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findBestCar(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE)
			->orderBy('place', 'asc');
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findPerfectPingedRide(Club $club, $place, $excludedCars = []){
		$query = $club->cars()
			->join('rides', 'rides.driver_id', '=', 'cars.driver_id')
			->where('rides.available_place', '=', $place)
			->where('rides.status', Ride::STATUS_PING);
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findBestPingedRide(Club $club, $place, $excludedCars = []){
		$query = Ride::join('cars', 'rides.driver_id', '=', 'cars.driver_id')
			->where('rides.available_place', '>=', $place)
			->where('rides.status', Ride::STATUS_PING)
			->orderBy('rides.available_place', 'asc');
		if(!is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}

    /**
     * Get or Create ride
     *
     * @Param App\Models\Item $item
     * @return App\Models\Ride
     */
    protected function getOrCreateRide($item)
	{
		$order = $item->order;
		$club = $item->club;
			
		// Attach this item to the ride
		$ride = $this->getPingedRide($item);
		if($ride){
			$count_back = $ride->items()->where('items.type', Item::TYPE_BACK)->count();
			$count_go = $ride->items()->where('items.type', Item::TYPE_GO)->count();

			// Durée du trajet + Arret sur tous les point de ramassage + Arret sur le point de depart
			$duration = $ride->duration_value + $count_go * 5 * 60 + ( $count_back > 0 ? 60 : 0 );
			$max_duration = 60 * 60; // Durée max 1 heure

			$place = 0;
			foreach($ride->items as $_item){
				if($_item->order){
					$place += $_item->order->place;
				}
			}
			$max_place = $car->place;

			if(($duration > $max_duration) || ($place + $order->place > $max_place)){
				// Durée du trajet depassé ou nombre de place atteint
				$start_date = $ride->start_at ? $ride->start_at->addSeconds($duration) : now()->addSeconds($duration); // Course après cette course en attente

				$ride = new Ride();
				$ride->status = Ride::STATUS_PING;
				$ride->car()->associate($car);
				$ride->driver()->associate($driver);
				$ride->save();

				$ride->setStartDate($start_date->addMinutes(5));
			}
		}else{
			$active_ride = $this->getStartedRide($item);
			if($active_ride){
				// Duree du trajet + Arret sur tous les point de ramassage + Arret sur le point de depart
				$count_back = $active_ride->items()->where('items.type', Item::TYPE_BACK)->count();
				$count_go = $active_ride->items()->where('items.type', Item::TYPE_GO)->count();

				$duration = $active_ride->duration  + $count_go * 5 * 60 + ( $count_back > 0 ? 60 : 0 );
				$start_date = $active_ride->started_at->addSeconds($duration);
			}else{
				// Aucune course active
				$start_date = now();
			}

			// Created new ride
			$ride = new Ride();
			$ride->status = Ride::STATUS_PING;
			$ride->car()->associate($car);
			$ride->driver()->associate($driver);
			$ride->save();

			// Notify date de debut
			$ride->setStartDate($start_date->addMinutes(5));
		}
		
		return $ride;
		
	}

    /**
     * Get pinged ride
     *
     * @Param App\Models\Item $item
     * @return mixed
     */
    protected function getPingedRide($item)
    {
		if($item->order){
			$query = Ride::where('car_id', $car->getKey());
			$query->where('status', Ride::STATUS_PING);
			$query->orderBy('start_at', 'asc');
			if($item->ride_at){
				$query->where('start_at', '>=', $item->ride_at);
			}
			return $query->first();
		}
		return null;
    }

    /**
     * Get actived ride
     *
     * @Param App\Models\Item $item
     * @return mixed
     */
    protected function getStartedRide($item)
    {
		if($item->order && $item->order->car){
        	$car = $item->order->car;
			$query = Ride::where('car_id', $car->getKey());
			$query->where('status', Ride::STATUS_STARTED);
			return $query->first();
		}
		return null;
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed($exception)
    {
        // Send user notification of failure, etc...
		info('Send user notification of failure...' . $exception->getMessage());
		info($exception);
    }
	
	
}
