<?php

namespace App\Listeners;

use App\Events\Ride\RideCancelable as RideCancelableEvent;
use App\Events\Ride\RideCanceled as RideCanceledEvent;
use App\Events\Ride\RideCompletable as RideCompletableEvent;
use App\Events\Ride\RideCompleted as RideCompletedEvent;
use App\Events\Ride\RideCreated as RideCreatedEvent;
use App\Events\Ride\RideDeleted as RideDeletedEvent;
use App\Events\Ride\RideStarted as RideStartedEvent;
use App\Events\Ride\RideStartDelayed as RideStartDelayedEvent;
use App\Events\Ride\RideStartForwarded as RideStartForwardedEvent;
use App\Events\Ride\RideStartInited as RideStartInitedEvent;
use App\Events\Ride\RideStartRefreshed as RideStartRefreshedEvent;

use App\Notifications\RideCancelable as RideCancelableNotification;
use App\Notifications\RideCanceled as RideCanceledNotification;
use App\Notifications\RideCompletable as RideCompletableNotification;
use App\Notifications\RideCompleted as RideCompletedNotification;
use App\Notifications\RideCreated as RideCreatedNotification;
use App\Notifications\RideDeleted as RideDeletedNotification;
use App\Notifications\RideStarted as RideStartedNotification;
use App\Notifications\RideStartDelayed as RideStartDelayedNotification;
use App\Notifications\RideStartForwarded as RideStartForwardedNotification;
use App\Notifications\RideStartInited as RideStartInitedNotification;
use App\Notifications\RideStartRefreshed as RideStartRefreshedNotification;

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
        $events->listen(RideCancelableEvent::class, self::class .'@handle');
        $events->listen(RideCanceledEvent::class, self::class .'@handle');
        $events->listen(RideCompletableEvent::class, self::class .'@handle');
        $events->listen(RideCompletedEvent::class, self::class .'@handle');
        $events->listen(RideCreatedEvent::class, self::class .'@handle');
        $events->listen(RideDeletedEvent::class, self::class .'@handle');
        $events->listen(RideStartedEvent::class, self::class .'@handle');
        $events->listen(RideStartDelayedEvent::class, self::class .'@handle');
        $events->listen(RideStartForwardedEvent::class, self::class .'@handle');
        $events->listen(RideStartInitedEvent::class, self::class .'@handle');
        $events->listen(RideStartRefreshedEvent::class, self::class .'@handle');
    }
    
    /**
     * Hande events.
     */
    public function handle($event) {
		if( !($ride = $event->ride) || !($driver = $ride->driver) ){
			return;
		}

		switch(true){
			case $event instanceof RideCancelableEvent:
				$driver->notify(new RideCancelableNotification($ride));
			break;
			case $event instanceof RideCanceledEvent:
				$driver->notify(new RideCanceledNotification($ride));
			break;
			case $event instanceof RideCompletableEvent:
				$driver->notify(new RideCompletableNotification($ride));
			break;
			case $event instanceof RideCompletedEvent:
				$driver->notify(new RideCompletedNotification($ride));
			break;
			case $event instanceof RideCreatedEvent:
				$driver->notify(new RideCreatedNotification($ride));
			break;
			case $event instanceof RideDeletedEvent:
				$driver->notify(new RideDeletedNotification($ride));
			break;
			case $event instanceof RideStartedEvent:
				$driver->notify(new RideStartedNotification($ride));
			break;
			case $event instanceof RideStartDelayedEvent:
				$driver->notify(new RideStartDelayedNotification($ride));
			break;
			case $event instanceof RideStartForwardedEvent:
				$driver->notify(new RideStartForwardedNotification($ride));
			break;
			case $event instanceof RideStartInitedEvent:
				$driver->notify(new RideStartInitedNotification($ride));
			break;
			case $event instanceof RideStartRefreshedEvent:
				$driver->notify(new RideStartRefreshedNotification($ride));
			break;
		}
    }
}
