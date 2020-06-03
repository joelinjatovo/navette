<?php

namespace App\Listeners;

use App\Events\RideItem\RideItemActived as RideItemActivedEvent;
use App\Events\RideItem\RideItemAttached as RideItemAttachedEvent;
use App\Events\RideItem\RideItemCanceled as RideItemCanceledEvent;
use App\Events\RideItem\RideItemCompleted as RideItemCompletedEvent;
use App\Events\RideItem\RideItemDetached as RideItemDetachedEvent;
use App\Events\RideItem\RideItemDriverArrived as RideItemDriverArrivedEvent;
use App\Events\RideItem\RideItemStarted as RideItemStartedEvent;

use App\Notifications\RideItemActived as RideItemActivedNotification;
use App\Notifications\RideItemAttached as RideItemAttachedNotification;
use App\Notifications\RideItemCanceled as RideItemCanceledNotification;
use App\Notifications\RideItemCompleted as RideItemCompletedNotification;
use App\Notifications\RideItemDetached as RideItemDetachedNotification;
use App\Notifications\RideItemDriverArrived as RideItemDriverArrivedNotification;
use App\Notifications\RideItemStarted as RideItemStartedNotification;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RideItemEventSubscriber
{
    
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(RideItemActivedEvent::class, self::class .'@handle');
        $events->listen(RideItemAttachedEvent::class, self::class .'@handle');
        $events->listen(RideItemCanceledEvent::class, self::class .'@handle');
        $events->listen(RideItemCompletedEvent::class, self::class .'@handle');
        $events->listen(RideItemDetachedEvent::class, self::class .'@handle');
        $events->listen(RideItemDriverArrivedEvent::class, self::class .'@handle');
        $events->listen(RideItemStartedEvent::class, self::class .'@handle');
    }
    
    /**
     * Hande events.
     */
    public function handle($event) {
		if( !($rideitem = $event->rideitem) || !($ride = $rideitem->ride) || !($driver = $ride->driver) ){
			return;
		}

		switch(true){
			case $event instanceof RideItemAttachedEvent:
				$driver->notify(new RideItemAttachedNotification($rideitem));
			break;
			case $event instanceof RideItemCanceledEvent:
				$driver->notify(new RideItemCanceledNotification($rideitem));
			break;
			case $event instanceof RideItemCompletedEvent:
				$driver->notify(new RideItemCompletedNotification($rideitem));
			break;
			case $event instanceof RideItemDetachedEvent:
				$driver->notify(new RideItemDetachedNotification($rideitem));
			break;
			case $event instanceof RideItemDriverArrivedEvent:
				$driver->notify(new RideItemDriverArrivedNotification($rideitem));
			break;
			case $event instanceof RideItemStartedEvent:
				$driver->notify(new RideItemStartedNotification($rideitem));
			break;
		}
    }
}
