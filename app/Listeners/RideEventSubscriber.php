<?php

namespace App\Listeners;

use App\Events\RideCarAssigned as RideCarAssignedEvent;
use App\Events\RideArrived as RideArrivedEvent;
use App\Events\RideCreated as RideCreatedEvent;
use App\Events\RideFinished as RideFinishedEvent;
use App\Events\RideReturned as RideReturnedEvent;
use App\Events\RideStarted as RideStartedEvent;
use App\Events\RideDriverAssigned as RideDriverAssignedEvent;
use App\Events\RideOrderActived as RideOrderActivedEvent;
use App\Events\RideOrderAssigned as RideOrderAssignedEvent;
use App\Events\RideOrderCanceled as RideOrderCanceledEvent;
use App\Events\RideOrderFinished as RideOrderFinishedEvent;
use App\Events\RideOrderMoved as RideOrderMovedEvent;
use App\Events\RideUserPointCreated as RideUserPointCreatedEvent;
use App\Notifications\RideOrderStatus as RideOrderStatusNotifiation;
use App\Notifications\RideStatus as RideStatusNotification;
use App\Notifications\RideUserPointCreated as RideUserPointCreatedNotifiation;
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
            'App\Events\RideCreated',
            'App\Listeners\RideEventSubscriber@handleRideCreated'
        );
        
        $events->listen(
            'App\Events\RideUpdated',
            'App\Listeners\RideEventSubscriber@handleRideUpdated'
        );
        
        $events->listen(
            'App\Events\RideDriverAttached',
            'App\Listeners\RideEventSubscriber@handleRideDriverAttached'
        );
        
        $events->listen(
            'App\Events\RideCarAttached',
            'App\Listeners\RideEventSubscriber@handleRideCarAttached'
        );
    }
    
    /**
     * Hande ride created events.
     */
    public function handleRideCreated(RideCreatedEvent $event) {
        $ride = $event->ride;
        $admin = $ride->user;
        if( null != $admin ) {
            $admin->notify(new RideStatusNotification($ride, 'created'));
        }
    }
    
    /**
     * Hande ride updated events.
     */
    public function handleRideUpdated(RideUpdatedEvent $event) {
        $ride = $event->ride;
        $admin = $ride->user;
        if( null != $admin ) {
            $admin->notify(new RideStatusNotification($ride, 'updated'));
        }
    }
    
    /**
     * Hande ride driver attached events.
     */
    public function handleRideDriverAttached(RideDriverAttachedEvent $event) {
        $ride = $event->ride;
        $driver = $ride->driver;
        if( null != $driver ) {
            $user->notify(new RideDriverAttachedNotifiation($ride));
        }
    }
    
    /**
     * Hande ride car attached events.
     */
    public function handleRideCarAttached(RideCarAttachedEvent $event) {
        $ride = $event->ride;
        $admin = $ride->user;
        if( null != $admin ) {
            $admin->notify(new RideCarAttachedNotifiation($ride));
        }
    }
    
    /**
     * Hande ride user position created events.
     */
    public function handleRideUserPointCreated(RideUserPointCreatedEvent $event) {
        $admin = $event->user;
        $point = $event->point;
        if( null != $admin ) {
            $admin->notify(new RideUserPointCreatedNotifiation($admin, $point));
        }
    }
}
