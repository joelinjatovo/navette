<?php

namespace App\Jobs;

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
    public function handle()
    {
        $driver = \App\Models\User::find(1);
        $car = \App\Models\Car::find(1);
        $travel = \App\Models\Travel::where('user_id', $driver->id)->where('car_id', $car->id)->first();
        if(null === $travel){
            $travel = \App\Models\Travel::create(['user_id' => $driver->id, 'car_id' => $car->id, 'status' => 'ping']);
            //event(new \App\Events\TravelCreated($travel));
        }else{
            //event(new \App\Events\TravelUpdated($travel));   
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
