<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged as OrderStatusChangedEvent;
use App\Notifications\OrderStatus as OrderStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\OrderStatusChanged',
            'App\Listeners\OrderEventSubscriber@handle'
        );
    }
    
    /**
     * Handle order created events.
     */
    public function handle(OrderStatusChangedEvent $event) {
        if( $event->order && $event->order->user ) {
            $event->order->user->notify(new OrderStatusNotification($event->order, $event->oldStatus, $event->newStatus));
        }
    }
}
