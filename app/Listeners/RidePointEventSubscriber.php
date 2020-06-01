<?php

namespace App\Listeners;

use App\Events\RidePoint\RidePointAttached as RidePointAttachedEvent;
use App\Events\RidePoint\RidePointCanceled as RidePointCanceledEvent;
use App\Events\RidePoint\RidePointCompleted as RidePointCompletedEvent;
use App\Events\RidePoint\RidePointDetached as RidePointDetachedEvent;

use App\Notifications\RidePointAttached as RidePointAttachedNotification;
use App\Notifications\RidePointCanceled as RidePointCanceledNotification;
use App\Notifications\RidePointCompleted as RidePointCompletedNotification;
use App\Notifications\RidePointDetached as RidePointDetachedNotification;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RidePointEventSubscriber
{
    
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(RidePointAttachedEvent::class, self::class .'@handle');
        $events->listen(RidePointCanceledEvent::class, self::class .'@handle');
        $events->listen(RidePointCompletedEvent::class, self::class .'@handle');
        $events->listen(RidePointDetachedEvent::class, self::class .'@handle');
    }
    
    /**
     * Hande events.
     */
    public function handle($event) {
		if( !($ridepoint = $event->ridepoint) || !($ride = $ridepoint->ride) || !($driver = $ride->driver) ){
			return;
		}

		switch(true){
			case $event instanceof RidePointAttachedEvent:
				$driver->notify(new RidePointAttachedNotification($ridepoint));
			break;
			case $event instanceof RidePointCanceledEvent:
				$driver->notify(new RidePointCanceledNotification($ridepoint));
			break;
			case $event instanceof RidePointCompletedEvent:
				$driver->notify(new RidePointCompletedNotification($ridepoint));
			break;
			case $event instanceof RidePointDetachedEvent:
				$driver->notify(new RidePointDetachedNotification($ridepoint));
			break;
		}
    }
}
