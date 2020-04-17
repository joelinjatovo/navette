<?php

namespace App\Listeners;

use App\Events\RideStatusChanged as RideStatusChangedEvent;
use App\Notifications\RideStatus as RideStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RideEventSubscriber
{
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
        if($event->ride && $event->ride->driver) {
            $ride->driver->notify(new RideStatusNotification($event->ride, $event->oldStatus, $event->newStatus));
        }
    }
}
