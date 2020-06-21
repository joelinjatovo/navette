<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\Club;
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
        $this->google = $google;

		// Handle job...
		$items = Item::where('items.status', Item::STATUS_OK)
			->whereNotNull('items.ride_at');
			/*
			->where(function($query) {
				$query->whereNull('items.ride_at');
				$query->orWhere('items.ride_at', '<=', now()->addMinutes(30));
			})
			*/
			->distinct('items.order_id')
			->get();

		$rides = [];
		foreach($items as $item){
			$ride = $this->performTask($item);
			if($ride && !isset($rides[$ride->getKey()])){
				$rides[$ride->getKey()] = $ride;
			}
		}
		
		foreach($rides as $ride){
			//$ride->verifyDirection($google);
			//$ride->verifyDates();
		} 
    }
	
    /**
     * Process this item
     *
     * @return boolean
     */
    protected function performTask(Item $item)
    {
		
		if(!($order = $item->order) || !($club = $order->club)){
			return null;
		}
		
		$max_ride_delay = 60; // 60 minutes par course
		$date = $this->getDate($item);
		
		// Try to add item to active ride
		$excludedRides = [];
		$rides = $this->getPerfectActivedRide($club, $item->ride_at, $order->place);
		foreach($rides as $ride){
			if(($ride->started_at->greaterThan($date))
			   && ($date->greaterThan($item->complete_at))){
				if($item->canJoinRide($ride)){
					break;
				}else{
					$excludedRides[] = $ride->getKey();
					$ride = null;
				}
			}
			
			if(($ride->duration_value <= (60 * $max_ride_delay))
			   && ($ride->started_at->greaterThan($date))
			   && ($date->greaterThan($item->started_at->addMinutes($max_ride_delay)))){
				if($item->canJoinRide($ride)){
					break;
				}else{
					$excludedRides[] = $ride->getKey();
					$ride = null;
				}
			}
		}
		
		if(!$ride){
			$rides = $this->getBestActivedRide($club, $item->ride_at, $order->place);
			foreach($rides as $ride){
				if(($ride->started_at->greaterThan($date))
				   && ($date->greaterThan($item->complete_at))){
					if($item->canJoinRide($ride)){
						break;
					}else{
						$excludedRides[] = $ride->getKey();
						$ride = null;
					}
				}

				if(($ride->duration_value <= (60 * $max_ride_delay))
				   && ($ride->started_at->greaterThan($date))
				   && ($date->greaterThan($item->started_at->addMinutes($max_ride_delay)))){
					if($item->canJoinRide($ride)){
						break;
					}else{
						$excludedRides[] = $ride->getKey();
						$ride = null;
					}
				}
			}
		}
		
		// Find locked car who has rides.available_place = order_place
		if(!$ride){
			$rides = $this->getPerfectPingedRide($club, $item->ride_at, $order->place);
			foreach($rides as $ride){
				if($ride->start_at->greaterThan($date)
				  && $date->greaterThan($ride->complete_at)){
					if($item->canJoinRide($ride)){
						break;
					}else{
						$excludedRides[] = $ride->getKey();
						$ride = null;
					}
				}
				
				if(($ride->duration_value <= (60 * $max_ride_delay))
				   && ($ride->started_at->greaterThan($date))
				   && ($date->greaterThan($item->start_at->addMinutes($max_ride_delay)))){
					if($item->canJoinRide($ride)){
						break;
					}else{
						$excludedRides[] = $ride->getKey();
						$ride = null;
					}
				}
			}
		}
		
		// Find locked car who has rides.available_place >= order_place
		if(!$ride){
			$rides = $this->getBestPingedRide($club, $item->ride_at, $order->place);
			foreach($rides as $ride){
				if($ride->start_at->greaterThan($date)
				  && $date->greaterThan($ride->complete_at)){
					if($item->canJoinRide($ride)){
						break;
					}else{
						$excludedRides[] = $ride->getKey();
						$ride = null;
					}
				}
				
				if(($ride->duration_value <= (60 * $max_ride_delay))
				   && ($ride->started_at->greaterThan($date))
				   && ($date->greaterThan($item->start_at->addMinutes($max_ride_delay)))){
					if($item->canJoinRide($ride)){
						break;
					}else{
						$excludedRides[] = $ride->getKey();
						$ride = null;
					}
				}
			}
		}
		
		// Find the available car who has place count
		if(!$ride){
			$car = $this->findPerfectCar($club, $item->ride_at, $order->place);
			if($car && $car->driver){
				$ride = $this->createRide($item, $car, $date);
			}
		}
		
		// Find the good car who has car_place >= ordered_place
		if(!$ride){
			$car = $this->findBestCar($club, $item->ride_at, $order->place);
			if($car && $car->driver){
				$ride = $this->createRide($item, $car, $date);
			}
		}
		
		// Create basic car
		if(!$ride){
			$car = $this->findCar($club, $item->ride_at, $order->place);
			if($car && $car->driver){
				$ride = $this->createRide($item, $car, $date);
			}
		}
		
		// Attach item to ride
		if($ride){
			$ride->attachItem($item, $order->place);
			$ride->addPlace($order->place);
			$item->active();
			$order->active();
		}else{
			info("No ride for " . $item->getKey());
		}
		
		return $ride;
    }
	
	private function createRide(Item $item, Car $car, $date){
		$ride = new Ride();
		$ride->status = Ride::STATUS_PING;
		$ride->available_place = $car->place;
		$ride->max_place = $car->place;
		$ride->club()->associate($car->club);
		$ride->driver()->associate($car->driver);
		if($ride->save()){
			$car->lock();
		}else{
			$ride = null;
		}
		
		if($ride){
			$has_active = Ride::where('status', Ride::STATUS_ACTIVE)->exists();
			$has_ping = Ride::where('status', Ride::STATUS_PING)->exists();
			if(!$has_active && !$has_ping){
				$ride->setStartDate($date);
			}elseif(!$has_active && $has_ping){
				//$ride->setStartDate($date);
			}
		}
		
		return $ride;
	}
	
	private function findPerfectCar(Club $club, $date, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE);
		if(is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findBestCar(Club $club, $date, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->where('status', Car::STATUS_AVAILABLE)
			->orderBy('place', 'asc');
		if(is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function findCar(Club $club, $date, $place, $excludedCars = []){
		$query = $club->cars()
			->where('place', '>=', $place)
			->whereHas('driver')
			->where('status', '!=', Car::STATUS_UNAVAILABLE)
			->orderBy('place', 'asc');
		if(is_array($excludedCars) && !empty($excludedCars)){
			$query->whereNotIn('cars.id', $excludedCars);
		}
		return $query->first();
	}
	
	private function getPerfectPingedRide(Club $club, $date, $place, $excludedRides = []){
		$query = $club->rides()
			->where('rides.available_place', '=', $place)
			->where('rides.status', Ride::STATUS_PING);
		if(is_array($excludedRides) && !empty($excludedRides)){
			$query->whereNotIn('rides.id', $excludedRides);
		}
		return $query->get();
	}
	
	private function getBestPingedRide(Club $club, $date, $place, $excludedRides = []){
		$query = $club->rides()
			->where('rides.available_place', '>=', $place)
			->where('rides.status', Ride::STATUS_PING)
			->orderBy('rides.available_place', 'asc');
		if(is_array($excludedRides) && !empty($excludedRides)){
			$query->whereNotIn('rides.id', $excludedRides);
		}
		return $query->get();
	}
	
	private function getPerfectActivedRide(Club $club, $date, $place, $excludedRides = []){
		$query = $club->rides()
			->where('rides.available_place', '=', $place)
			->where('rides.status', Ride::STATUS_ACTIVE);
		if(is_array($excludedRides) && !empty($excludedRides)){
			$query->whereNotIn('rides.id', $excludedRides);
		}
		return $query->get();
	}
	
	private function getBestActivedRide(Club $club, $date, $place, $excludedRides = []){
		$query = $club->rides()
			->where('rides.available_place', '>=', $place)
			->where('rides.status', Ride::STATUS_ACTIVE);
		if(is_array($excludedRides) && !empty($excludedRides)){
			$query->whereNotIn('rides.id', $excludedRides);
		}
		return $query->get();
	}
	
    private function getDate(Item $item)
    {
		$notification_delay = $item->type == Item::TYPE_GO ?  ( 7 + 5 ) * 60 : ( 15 + 5 ) * 60;
		$date = $item->ride_at
			->subSeconds($item->duration_value)
			->subSeconds($notification_delay);
		if($date->greaterThan(now())){
			$date = $item->ride_at
				->subSeconds($item->duration_value);
		}
		if($date->greaterThan(now())){
			$date = $item->ride_at;
		}
		if($date->greaterThan(now())){
			$date = now();
		}
		
		return $date;
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
