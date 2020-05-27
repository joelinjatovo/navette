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
        \Log::info('RideProcessor->handle()');
		$items = Item::join('orders', 'orders.id', '=', 'items.order_id')
			->where('orders.status', Order::STATUS_OK)
			->where('items.status', Item::STATUS_PING)
            ->where(function($query) {
                $query->whereNull('items.ride_at')
                      ->orWhere('items.ride_at', '<=', now()->addMinutes(30));
            })
			->get();
		if($items){
			foreach($items as $item){
				$this->performTask($item);
			}
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
        // Attach this item to the ride
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
	
	
}
