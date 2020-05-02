<?php

namespace App\Listeners;

use App\Events\ItemStatusChanged as ItemStatusChangedEvent;
use App\Notifications\ItemStatus as ItemStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ItemEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\ItemStatusChanged',
            'App\Listeners\ItemEventSubscriber@handle'
        );
    }
    
    /**
     * Hande Ride status changed events.
     */
    public function handle(ItemStatusChangedEvent $event) {
        if($event->item && $event->item->order && $event->item->order->user) {
            $event->item->order->user->notify(new ItemStatusNotification($event->item, $event->oldStatus, $event->newStatus));
        }
    }
}
