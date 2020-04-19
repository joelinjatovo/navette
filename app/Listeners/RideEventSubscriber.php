<?php

namespace App\Listeners;

use App\Models\Ride;
use App\Events\RideStatusChanged as RideStatusChangedEvent;
use App\Notifications\RideStatus as RideStatusNotification;
use App\Services\GoogleApiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RideEventSubscriber
{
    protected $google;

    /**
     * Paginate orders
     *
     * @return Response
     */
    public function __construct(GoogleApiService $google){
        $this->google = $google;
    }
    
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\RideStatusChanged',
            'App\Listeners\RideEventSubscriber@handle'
        );
    }
    
    /**
     * Hande Ride status changed events.
     */
    public function handle(RideStatusChangedEvent $event) {
        $ride = $event->ride;
        if($ride == null){
            return;
        }
        
        $driver = $ride->driver;
        if($driver == null){
            return;
        }
        
        $driver->notify(new RideStatusNotification($ride, $event->oldStatus, $event->newStatus));
    }
}
