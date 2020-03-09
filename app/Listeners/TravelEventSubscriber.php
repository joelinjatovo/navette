<?php

namespace App\Listeners;

use App\Events\TravelCarAssigned as TravelCarAssignedEvent;
use App\Events\TravelArrived as TravelArrivedEvent;
use App\Events\TravelCreated as TravelCreatedEvent;
use App\Events\TravelFinished as TravelFinishedEvent;
use App\Events\TravelReturned as TravelReturnedEvent;
use App\Events\TravelStarted as TravelStartedEvent;
use App\Events\TravelDriverAssigned as TravelDriverAssignedEvent;
use App\Events\TravelOrderActived as TravelOrderActivedEvent;
use App\Events\TravelOrderAssigned as TravelOrderAssignedEvent;
use App\Events\TravelOrderCanceled as TravelOrderCanceledEvent;
use App\Events\TravelOrderFinished as TravelOrderFinishedEvent;
use App\Events\TravelOrderMoved as TravelOrderMovedEvent;
use App\Events\TravelUserPointCreated as TravelUserPointCreatedEvent;
use App\Notifications\TravelOrderStatus as TravelOrderStatusNotifiation;
use App\Notifications\TravelStatus as TravelStatusNotification;
use App\Notifications\TravelUserPointCreated as TravelUserPointCreatedNotifiation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class TravelEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\TravelCreated',
            'App\Listeners\TravelEventSubscriber@handleTravelCreated'
        );
        
        $events->listen(
            'App\Events\TravelUpdated',
            'App\Listeners\TravelEventSubscriber@handleTravelUpdated'
        );
        
        $events->listen(
            'App\Events\TravelDriverAttached',
            'App\Listeners\TravelEventSubscriber@handleTravelDriverAttached'
        );
        
        $events->listen(
            'App\Events\TravelCarAttached',
            'App\Listeners\TravelEventSubscriber@handleTravelCarAttached'
        );
    }
    
    /**
     * Handle travel created events.
     */
    public function handleTravelCreated(TravelCreatedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelStatusNotification($travel, 'created'));
        }
    }
    
    /**
     * Handle travel updated events.
     */
    public function handleTravelUpdated(TravelUpdatedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelStatusNotification($travel, 'updated'));
        }
    }
    
    /**
     * Handle travel driver attached events.
     */
    public function handleTravelDriverAttached(TravelDriverAttachedEvent $event) {
        $travel = $event->travel;
        $driver = $travel->driver;
        if( null != $driver ) {
            $user->notify(new TravelDriverAttachedNotifiation($travel));
        }
    }
    
    /**
     * Handle travel car attached events.
     */
    public function handleTravelCarAttached(TravelCarAttachedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelCarAttachedNotifiation($travel));
        }
    }
    
    /**
     * Handle travel user position created events.
     */
    public function handleTravelUserPointCreated(TravelUserPointCreatedEvent $event) {
        $admin = $event->user;
        $point = $event->point;
        if( null != $admin ) {
            $admin->notify(new TravelUserPointCreatedNotifiation($admin, $point));
        }
    }
}
