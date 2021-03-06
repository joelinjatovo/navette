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

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param  $order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        $car = $order->car;
        $driver = $order->car->driver;
        $club = $order->club;
        
        $ride = $this->getAvailableRide($car);
        if(!$ride){
            $ride = new Ride();
            $ride->status = Ride::STATUS_PING;
            $ride->car()->associate($car);
            $ride->driver()->associate($driver);
            $ride->save();
            
            // Notify *driver
            event(new RideStatusChanged($ride, 'created', null, $ride->status));
        }else{
            // Notify *driver
            event(new RideStatusChanged($ride, 'updated', null, $ride->status));
        }
        
        switch($order->type){
            case Order::TYPE_GO:
            case Order::TYPE_BACK:
                $item = $order->items()->first();

                // Attach the item's order point to the ride
                $type = RidePoint::TYPE_PICKUP;
                if($item->type == Item::TYPE_BACK){
                    $type = RidePoint::TYPE_DROP;
                }
                $ride->points()->attach($item->point->getKey(), [
                        'status' => RidePoint::STATUS_PING,
                        'type' => $type,
                        'order' => 0,
                    ]);
                
                if($item->ride_at == null){
                    // Calculate
                    $item->ride_at = Carbon::now()->addMinutes(10);
                }

                // Set item status ACTIVE
                $oldStatus = $item->status;
                $newStatus = Item::STATUS_ACTIVE;
                $item->status = $newStatus;
                $item->ride()->associate($ride);
                $item->driver()->associate($driver);
                $item->save();

                // Notify *customer
                event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
                break;
            case Order::TYPE_GO_BACK:
            case Order::TYPE_CUSTOM:
                // @TODO Implement processor GO BACK Order Items
                break;
        }
        
        // Set order status ACTIVE
        $oldStatus = $order->status;
        $newStatus = Order::STATUS_ACTIVE;
        
        $order->status = $newStatus;
        $order->save();
        
        // Notify *customer
        event(new OrderStatusChanged($order, 'updated', $oldStatus, $newStatus));
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

    /**
     * Get availbale ride
     *
     * @Param App\Models\Car $car
     * @return mixed
     */
    public function getAvailableRide($car)
    {
        $from = now()->toDateTimeString(); // 2018-09-29 12:45:12
        $to = now()->subMinute(60)->toDateTimeString(); // 2018-09-29 11:45:12
        return Ride::where('car_id', $car->getKey())
            ->where('status', Ride::STATUS_PING)
            ->whereNull('started_at')
            ->whereNull('canceled_at')
            //->where('start_at', '>', $from)->where('will_start_at', '<', $to)
            ->first();
    }
        
}
