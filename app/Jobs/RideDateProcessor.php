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

class RideDateProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ride;

    /**
     * Create a new job instance.
     *
     * @param  Ride $ride
     * @return void
     */
    public function __construct(Ride $ride)
    {
        $this->ride = $ride;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('RideDateProcessor->handle()');
		
        $ride = $this->ride;
      
        $points = $ride->points()->wherePivotIn('status', [RidePoint::STATUS_ACTIVE, RidePoint::STATUS_NEXT])->get();
        if(empty($points)){
            return false;
        }
      
        // Notifier ces points selon la position du driver
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
