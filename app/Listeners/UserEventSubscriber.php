<?php

namespace App\Listeners;

use App\Mail\UserLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserEventSubscriber
{   

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@handleUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@handleUserLogout'
        );
        
        $events->listen(
            'App\Events\UserPointCreated',
            'App\Listeners\UserEventSubscriber@handleUserPointCreated'
        );
    }
    
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event) {
        //Mail::to($event->user)->send(new UserLogin($event->user));
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event) {
        
    }
    
    /**
     * Handle user position created events.
     */
    public function handleUserPointCreated(\App\Events\UserPointCreated $event) {
        $user = $event->user;
        $point = $event->point;
        if( null != $user ) {
            $user->notify(new \App\Notifications\UserPointCreated($user, $point));
        }
    }
}
