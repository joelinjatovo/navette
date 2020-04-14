<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\OrderPoint;
use App\Models\Order;
use App\Models\Ride;
use App\Models\RidePoint;
use App\Models\User;
use App\Services\RideProcessor;
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
        $driver = User::find(1);
        $car = Car::find(1);
        $ride = Ride::where('driver_id', $driver->getKey())->where('car_id', $car->getKey())->first();
        if(null === $ride){
            $ride = Ride::create(['user_id' => $driver->getKey(), 'car_id' => $car->getKey(), 'status' => 'ping']);
            //event(new \App\Events\RideCreated($ride));
        }else{
            //event(new \App\Events\RideUpdated($ride));   
        }
        $ride->save();
        
        $this->order->ride_id = $ride->getKey();
        $this->order->save();
        //$ride->orders()->save($this->order);
        
        foreach($this->order->points()->where('type', OrderPoint::TYPE_START)->get() as $point){
            $ride->points()->attach($point->getKey(), [
                'created_at' => now(), 
                'status' => RidePoint::STATUS_PING, 
                'type' => RidePoint::TYPE_PICKUP
            ]);
        }
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
