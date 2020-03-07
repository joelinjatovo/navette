<?php

namespace App\Listeners;

use App\Events\OrderCreated as OrderCreatedEvent;
use App\Events\OrderChanged as OrderChangedEvent;
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
            '\App\Events\OrderCreated',
            '\App\Listeners\OrderEventSubscriber@handleOrderCreated'
        );
    }
    
    /**
     * Handle order created events.
     */
    public function handleOrderCreated(OrderCreatedEvent $event) {
        $order = $event->order;
        $user = $order->user;
        if( null != $user ) {
            $user->notify(new OrderStatusNotification($order, 'created'));
        }
    }
    
    /**
     * Handle order changed events.
     */
    public function handleOrderChanged(OrderChangedEvent $event) {
        $order = $event->order;
        $user = $order->user;
        if( null != $user ) {
            $user->notify(new OrderStatusNotification($order, 'changed'));
        }
    }
}
