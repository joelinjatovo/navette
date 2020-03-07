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
}
