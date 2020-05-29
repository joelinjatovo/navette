<?php

namespace App\Jobs;

use App\Events\ItemStatusChanged;
use App\Events\OrderStatusChanged;
use App\Events\RideStatusChanged;
use App\Models\Car;
use App\Models\Item;
use App\Models\Order;
use App\Models\Ride;
use App\Models\RidePoint;
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
			->where(function($query) {
				$query->where('items.status', Item::STATUS_PING);
				$query->where(function($query) {
					$query->where('orders.type', Order::TYPE_GO);
					$query->orWhere('orders.type', Order::TYPE_BACK);
				});
			})
			->where(function($query) {
				$query->whereNull('items.ride_at');
				$query->orWhere('items.ride_at', '<=', now()->addMinutes(30));
			})
			->get();

		foreach($items as $item){
			$this->performTask($item);
		}
    }
	
    /**
     * Process this item
     *
     * @param  Exception  $exception
     * @return void
     */
    protected function performTask(Item $item)
    {
		if($item->order && $item->order->car){
			$order = $item->order;
			$car = $item->order->car;
			$driver = $item->order->car->driver;
			$user = $item->user;
			
			// Attach this item to the ride
			$ride = $this->getPingedRide($item);
			if($ride){
				$count_back = $ride->items()->where('items.type', Item::TYPE_BACK)->count();
				$count_go = $ride->items()->where('items.type', Item::TYPE_GO)->count();
				
				// Durée du trajet + Arret sur tous les point de ramassage + Arret sur le point de depart
				$duration = $ride->duration + $count_go * 5 * 60 + ( $count_back > 0 ? 60 : 0 );
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
					$ride->start_at = $start_date->addMinutes(5);
					$ride->car()->associate($car);
					$ride->driver()->associate($driver);
					$ride->save();

					$event_ride = new RideStatusChanged($ride, 'created', null, $ride->status);
				}else{
					// Ajouter le point à ce point
					$event_ride = new RideStatusChanged($ride, 'updated', null, $ride->status);
				}
			}else{
				$active_ride = $this->getActivedRide($item);
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
				$ride->start_at = $start_date->addMinutes(5);
				$ride->car()->associate($car);
				$ride->driver()->associate($driver);
				$ride->save();
				
				$event_ride = new RideStatusChanged($ride, 'created', null, $ride->status);
			}
			
			// Attach the item's order point to the ride
			$ride->attach($item);
			
			$ride->verifyDirection($this->google);
			
			// Triger events
			event($event_ride);
		}
    }

    /**
     * Get pinged ride
     *
     * @Param App\Models\Item $item
     * @return mixed
     */
    protected function getPingedRide($item)
    {
		if($item->order && $item->order->car){
        	$car = $item->order->car;
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
    protected function getActivedRide($item)
    {
		if($item->order && $item->order->car){
        	$car = $item->order->car;
			$query = Ride::where('car_id', $car->getKey());
			$query->where('status', Ride::STATUS_ACTIVE);
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
    }
	
	
}
