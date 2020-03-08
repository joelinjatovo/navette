<?php

namespace App\Listeners;

use App\Events\UserPointCreated as UserPointCreatedEvent;
use App\Notifications\UserPointCreated as UserPointCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class UserPointEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\UserPointCreated',
            'App\Listeners\UserPointEventSubscriber@handleUserPointCreated'
        );
    }
    
    /**
     * Handle user position created events.
     */
    public function handleUserPointCreated(UserPointCreatedEvent $event) {
        $admin = $event->user;
        $point = $event->point;
        if( null != $admin ) {
            $admin->notify(new UserPointCreatedNotification($admin, $point));
        }
    }
}
