<?php

namespace App\Listeners;

use App\Events\UserPositionCreated as UserPositionCreatedEvent;
use App\Notifications\UserPositionCreated as UserPositionCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class UserPositionEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\UserPositionCreated',
            'App\Listeners\UserPositionEventSubscriber@handleUserPositionCreated'
        );
    }
    
    /**
     * Handle user position created events.
     */
    public function handleUserPositionCreated(UserPositionCreatedEvent $event) {
        $admin = $event->user;
        $point = $event->point;
        if( null != $admin ) {
            $admin->notify(new UserPositionCreatedNotification($admin, $point));
        }
    }
}
