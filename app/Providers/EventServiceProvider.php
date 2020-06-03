<?php

namespace App\Providers;

use App\Events\RideInited;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        '\Illuminate\Auth\Events\Registered' => [
            '\App\Listeners\SendPhoneVerificationNotification',
        ],
        '\Illuminate\Notifications\Events\NotificationSent' => [
            '\App\Listeners\LogNotification',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\ItemEventSubscriber',
        'App\Listeners\OrderEventSubscriber',
        'App\Listeners\RideEventSubscriber',
        'App\Listeners\RideItemEventSubscriber',
        'App\Listeners\UserEventSubscriber',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
