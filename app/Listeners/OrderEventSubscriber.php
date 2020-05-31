<?php

namespace App\Listeners;

use App\Events\Order\OrderActived as OrderActivedEvent;
use App\Events\Order\OrderCanceled as OrderCanceledEvent;
use App\Events\Order\OrderCreated as OrderCreatedEvent;
use App\Events\Order\OrderCompleted as OrderCompletedEvent;
use App\Events\Order\OrderDeleted as OrderDeletedEvent;
use App\Events\Order\OrderPaid as OrderPaidEvent;
use App\Events\Order\OrderPlaceChanged as OrderPlaceChangedEvent;
use App\Events\Order\OrderRefunded as OrderRefundedEvent;

use App\Notifications\OrderActived as OrderActivedNotification;
use App\Notifications\OrderCanceled as OrderCanceledNotification;
use App\Notifications\OrderCreated as OrderCreatedNotification;
use App\Notifications\OrderCompleted as OrderCompletedNotification;
use App\Notifications\OrderDeleted as OrderDeletedNotification;
use App\Notifications\OrderPaid as OrderPaidNotification;
use App\Notifications\OrderPlaceChanged as OrderPlaceChangedNotification;
use App\Notifications\OrderRefunded as OrderRefundedNotification;

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
        $events->listen(OrderActivedEvent::class, self::class .'@handle');
        $events->listen(OrderCanceledEvent::class, self::class .'@handle');
        $events->listen(OrderCreatedEvent::class, self::class .'@handle');
        $events->listen(OrderCompletedEvent::class, self::class .'@handle');
        $events->listen(OrderDeletedEvent::class, self::class .'@handle');
        $events->listen(OrderPaidEvent::class, self::class .'@handle');
        $events->listen(OrderPlaceChangedEvent::class, self::class .'@handle');
        $events->listen(OrderRefundedEvent::class, self::class .'@handle');
    }
    
    public function handle($event) {
		if( !($order = $event->order) || !($user = $order->user) ){
			return;
		}

		switch(true){
			case $event instanceof OrderActivedEvent:
				$user->notify(new OrderActivedNotification($order));
			break;
			case $event instanceof OrderCanceledEvent:
				$user->notify(new OrderCanceledNotification($order));
			break;
			case $event instanceof OrderCreatedEvent:
				$user->notify(new OrderCreatedNotification($order));
			break;
			case $event instanceof OrderCompletedEvent:
				$user->notify(new OrderCompletedNotification($order));
			break;
			case $event instanceof OrderDeletedEvent:
				$user->notify(new OrderDeletedNotification($order));
			break;
			case $event instanceof OrderPaidEvent:
				$user->notify(new OrderPaidNotification($order));
			break;
			case $event instanceof OrderPlaceChangedEvent:
				$user->notify(new OrderPlaceChangedNotification($order));
			break;
			case $event instanceof OrderRefundedEvent:
				$user->notify(new OrderRefundedNotification($order));
			break;
		}
    }
}
