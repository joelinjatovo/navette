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
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RideProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function handle()
    {
		info('RideProcessor...');

		// Handle job...
		$items = Item::join('orders', 'orders.id', '=', 'items.order_id')
			->where('orders.status', Order::STATUS_OK)
			->where('items.status', Item::STATUS_PING)
			->where(function($query) {
				$query->whereNull('items.ride_at')
					  ->orWhere('items.ride_at', '<=', now()->addMinutes(30));
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
			// Attach this item to the ride
			$ride = $this->getPingedRide($item);
			$start_date = now()->addMinutes(5);
			if($ride){
				$count_back = $ride->items()->where('items.type', Item::TYPE_BACK)->count();
				$count_go = $ride->items()->where('items.type', Item::TYPE_GO)->count();
				$count = $count_go + $count_back;
				// Duree du trajet + Arret sur tous les point de ramassage + Arret sur le point de depart
				$duration = $ride->duration + ( $count_go + 1 ) * 5 * 60;
				$max = 60 * 60;

				// TODO Check duration
				$event_ride = new RideStatusChanged($ride, 'updated', null, $ride->status);
			}else{
				$active_ride = $this->getActivedRide($item);
				if($active_ride){
					// Duree du trajet + Arret sur tous les point de ramassage + Arret sur le point de depart
					$count_go = $ride->items()->where('items.type', Item::TYPE_GO)->count();
					$duration = $active_ride->duration + ( $count_go + 1 ) * 5 * 60;
					$start_date = $active_ride->started_at->addSeconds($duration);
				}

				// Created new ride
				$ride = new Ride();
				$ride->status = Ride::STATUS_PING;
				$ride->start_at = $start_date->addMinutes(5);
				$ride->car()->associate($item->order->car);
				$ride->driver()->associate($item->order->car->driver);
				$ride->save();
				
				$event_ride = new RideStatusChanged($ride, 'created', null, $ride->status);
			}
			
			// Attach the item's order point to the ride
			$item_start_at = $ride->start_at->addMinutes(5)->addSeconds($item->duration_value);
			$ride->points()->attach($item->point->getKey(), [
				'status' => RidePoint::STATUS_PING,
				'type' => ($item->type == Item::TYPE_BACK ? RidePoint::TYPE_DROP : RidePoint::TYPE_PICKUP),
				'order' => 0,
				'arrive_at' => $item_start_at,
				'item_id' => $item->getKey(),
				'user_id' => $item->user ? $item->user->getKey() : null,
			]);


			// Set item status ACTIVE
			$oldStatus = $item->status;
			$newStatus = Item::STATUS_ACTIVE;
			$item->status = $newStatus;
			$item->start_at = $item_start_at;
			$item->ride()->associate($ride);
			$item->driver()->associate($driver);
			$item->save();
			$event_item = new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus);
			
			// Set order status ACTIVE
			$oldStatus = $order->status;
			$newStatus = Order::STATUS_ACTIVE;
			$order->status = $newStatus;
			$order->save();
			$event_order = new OrderStatusChanged($order, 'updated', $oldStatus, $newStatus);

			// Triger events
			event($event_ride);
			event($event_item);
			event($event_order);
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
			$query = Ride::where('car_id', $car->getKey())->where('status', Ride::STATUS_PING)->orderBy('start_at', 'asc');
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
			$query = Ride::where('car_id', $car->getKey())->where('status', Ride::STATUS_ACTIVE)
				->where('duration', '<', 15 * 60);
				->orderBy('start_at', 'asc');
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
    public function failed(\Exception $exception)
    {
        // Send user notification of failure, etc...
		info('Send user notification of failure...' . $exception->getMessage());
    }
	
	
}
