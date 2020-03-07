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
use App\Events\TravelUserPositionCreated as TravelUserPositionCreatedEvent;
use App\Notifications\TravelOrderStatus as TravelOrderStatusNotifiation;
use App\Notifications\TravelStatus as TravelStatusNotification;
use App\Notifications\TravelUserPositionCreated as TravelUserPositionCreatedNotifiation;
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
            '\App\Events\TravelCreated',
            '\App\Listeners\TravelEventSubscriber@handleTravelCreated'
        );
        
        $events->listen(
            '\App\Events\TravelStarted',
            '\App\Listeners\TravelEventSubscriber@handleTravelStarted'
        );
        
        $events->listen(
            '\App\Events\TravelArrived',
            '\App\Listeners\TravelEventSubscriber@handleTravelStarted'
        );
        
        $events->listen(
            '\App\Events\TravelReturned',
            '\App\Listeners\TravelEventSubscriber@handleTravelReturned'
        );
        
        $events->listen(
            '\App\Events\TravelFinished',
            '\App\Listeners\TravelEventSubscriber@handleTravelFinished'
        );
        
        $events->listen(
            '\App\Events\TravelDriverAssigned',
            '\App\Listeners\TravelEventSubscriber@handleTravelDriverAssigned'
        );
        
        $events->listen(
            '\App\Events\TravelCarAssigned',
            '\App\Listeners\TravelEventSubscriber@handleTravelCarAssigned'
        );
        
        $events->listen(
            '\App\Events\TravelOrderAssigned',
            '\App\Listeners\TravelEventSubscriber@handleTravelOrderAssigned'
        );
        
        $events->listen(
            '\App\Events\TravelOrderActived',
            '\App\Listeners\TravelEventSubscriber@handleTravelOrderActived'
        );
        
        $events->listen(
            '\App\Events\TravelOrderCanceled',
            '\App\Listeners\TravelEventSubscriber@handleTravelOrderCanceled'
        );
        
        $events->listen(
            '\App\Events\TravelOrderMoved',
            '\App\Listeners\TravelEventSubscriber@handleTravelOrderMoved'
        );
        
        $events->listen(
            '\App\Events\TravelOrderFinished',
            '\App\Listeners\TravelEventSubscriber@handleTravelOrderFinished'
        );
        
        $events->listen(
            '\App\Events\TravelUserPositionCreated',
            '\App\Listeners\TravelEventSubscriber@handleTravelUserPositionCreated'
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
     * Handle travel started events.
     */
    public function handleTravelStarted(TravelStartedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelStatusNotification($travel, 'started'));
        }
    }
    
    /**
     * Handle travel inited events.
     */
    public function handleTravelArrived(TravelArrivedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelStatusNotification($travel, 'arrived'));
        }
    }
    
    /**
     * Handle travel returned events.
     */
    public function handleTravelReturned(TravelReturnedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelStatusNotification($travel, 'returned'));
        }
    }
    
    /**
     * Handle travel finished events.
     */
    public function handleTravelReturned(TravelFinishedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelStatusNotification($travel, 'finished'));
        }
    }
    
    /**
     * Handle travel driver assigned events.
     */
    public function handleTravelDriverAssigned(TravelDriverAssignedEvent $event) {
        $travel = $event->travel;
        $driver = $travel->driver;
        if( null != $driver ) {
            $user->notify(new TravelDriverAssignedNotifiation($travel));
        }
    }
    
    /**
     * Handle travel car assigned events.
     */
    public function handleTravelCarAssigned(TravelCarAssignedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelCarAssignedNotifiation($travel));
        }
    }
    
    /**
     * Handle travel order assigned events.
     */
    public function handleTravelOrderAssigned(TravelOrderAssignedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelOrderStatusNotifiation($travel, 'assigned'));
        }
    }
    
    /**
     * Handle travel order actived events.
     */
    public function handleTravelOrderActived(TravelOrderActivedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelOrderStatusNotifiation($travel, 'actived'));
        }
    }
    
    /**
     * Handle travel order canceled events.
     */
    public function handleTravelOrderCanceled(TravelOrderCanceledEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelOrderStatusNotifiation($travel, 'canceled'));
        }
    }
    
    /**
     * Handle travel order moved events.
     */
    public function handleTravelOrderMoved(TravelOrderMovedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelOrderStatusNotifiation($travel, 'moved'));
        }
    }
    
    /**
     * Handle travel order moved events.
     */
    public function handleTravelOrderFinished(TravelOrderFinishedEvent $event) {
        $travel = $event->travel;
        $admin = $travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelOrderStatusNotifiation($travel, 'finished'));
        }
    }
    
    /**
     * Handle travel user position created events.
     */
    public function handleTravelOrderFinished(TravelUserPositionCreated $event) {
        $position = $event->position;
        $admin = $position->travel->user;
        if( null != $admin ) {
            $admin->notify(new TravelUserPositionCreatedNotifiation($position));
        }
    }
}
