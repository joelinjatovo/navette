<?php

namespace App\Jobs;

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
    public function __construct(\App\Models\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RideProcessor $processor)
    {
        $driver = \App\Models\User::find(1);
        $car = \App\Models\Car::find(1);
        $ride = \App\Models\Ride::where('user_id', $driver->id)->where('car_id', $car->id)->first();
        if(null === $ride){
            $ride = \App\Models\Ride::create(['user_id' => $driver->id, 'car_id' => $car->id, 'status' => 'ping']);
            //event(new \App\Events\RideCreated($ride));
        }else{
            //event(new \App\Events\RideUpdated($ride));   
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
