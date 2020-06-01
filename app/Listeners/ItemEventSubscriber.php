<?php

namespace App\Listeners;

use App\Models\Item;

use App\Events\Item\ItemActived as ItemActivedEvent;
use App\Events\Item\ItemCanceled as ItemCanceledEvent;
use App\Events\Item\ItemCompleted as ItemCompletedEvent;
use App\Events\Item\ItemDateDelayed as ItemDateDelayedEvent;
use App\Events\Item\ItemDateForwarded as ItemDateForwardedEvent;
use App\Events\Item\ItemDateInited as ItemDateInitedEvent;
use App\Events\Item\ItemDateRefreshed as ItemDateRefreshedEvent;
use App\Events\Item\ItemDeleted as ItemDeletedEvent;
use App\Events\Item\ItemDetached as ItemDetachedEvent;
use App\Events\Item\ItemDriverArrived as ItemDriverArrivedEvent;
use App\Events\Item\ItemNexted as ItemNextedEvent;
use App\Events\Item\ItemStarted as ItemStartedEvent;

use App\Notifications\ItemActived as ItemActivedNotification;
use App\Notifications\ItemCanceled as ItemCanceledNotification;
use App\Notifications\ItemCompleted as ItemCompletedNotification;
use App\Notifications\ItemDateDelayed as ItemDateDelayedNotification;
use App\Notifications\ItemDateForwarded as ItemDateForwardedNotification;
use App\Notifications\ItemDateInited as ItemDateInitedNotification;
use App\Notifications\ItemDateRefreshed as ItemDateRefreshedNotification;
use App\Notifications\ItemDeleted as ItemDeletedNotification;
use App\Notifications\ItemDetached as ItemDetachedNotification;
use App\Notifications\ItemDriverArrived as ItemDriverArrivedNotification;
use App\Notifications\ItemNexted as ItemNextedNotification;
use App\Notifications\ItemStarted as ItemStartedNotification;

use App\Notifications\PickupDate as PickupDateNotification;

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
        $events->listen(ItemActivedEvent::class, self::class .'@handle');
        $events->listen(ItemCanceledEvent::class, self::class .'@handle');
        $events->listen(ItemCompletedEvent::class, self::class .'@handle');
        $events->listen(ItemDateDelayedEvent::class, self::class .'@handle');
        $events->listen(ItemDateForwardedEvent::class, self::class .'@handle');
        $events->listen(ItemDateInitedEvent::class, self::class .'@handle');
        $events->listen(ItemDateRefreshedEvent::class, self::class .'@handle');
        $events->listen(ItemDeletedEvent::class, self::class .'@handle');
        $events->listen(ItemDetachedEvent::class, self::class .'@handle');
        $events->listen(ItemDriverArrivedEvent::class, self::class .'@handle');
        $events->listen(ItemNextedEvent::class, self::class .'@handle');
        $events->listen(ItemStartedEvent::class, self::class .'@handle');
    }
    
    /**
     * Hande events.
     */
    public function handle($event) {
		if( !($item = $event->item) || !($user = $item->user) ){
			return;
		}

		switch(true){
			case $event instanceof ItemActivedEvent:
				$user->notify(new ItemActivedNotification($item));
			break;
			case $event instanceof ItemCanceledEvent:
				$user->notify(new ItemCanceledNotification($item));
			break;
			case $event instanceof ItemCompletedEvent:
				$user->notify(new ItemCompletedNotification($item));
			break;
			case $event instanceof ItemDateDelayedEvent:
				$user->notify(new ItemDateDelayedNotification($item));
			break;
			case $event instanceof ItemDateForwardedEvent:
				$user->notify(new ItemDateForwardedNotification($item));
			break;
			case $event instanceof ItemDateInitedEvent:
				$user->notify(new ItemDateInitedNotification($item));
				
				if($item->type == Item::TYPE_GO){
					$ridepoint = $item->ridePoints()->first();
					if($ridepoint){
						$delay = 7 * 60;
						if($ridepoint->duration_value < $delay){
							$notification = new PickupDateNotification($item, $ridepoint->duration);
						}else{
							$when = now()->addSeconds($ridepoint->duration_value - $delay);
							$notification = new PickupDateNotification($item, '7 min');
							$notification->delay($when);
						}
						$user->notify($notification);
					}
				}else{
					if($item->ride && $item->ride->start_at){
						$when = $item->ride->start_at->subSeconds(5 * 60);
						$notification = new PickupDateNotification($item, '5 min');
						$notification->delay($when);
						$user->notify($notification);
					}
				}
			break;
			case $event instanceof ItemDateRefreshedEvent:
				$user->notify(new ItemDateRefreshedNotification($item));
			break;
			case $event instanceof ItemDeletedEvent:
				$user->notify(new ItemDeletedNotification($item));
			break;
			case $event instanceof ItemDetachedEvent:
				$user->notify(new ItemDetachedNotification($item));
			break;
			case $event instanceof ItemDriverArrivedEvent:
				$user->notify(new ItemDriverArrivedNotification($item));
			break;
			case $event instanceof ItemNextedEvent:
				$user->notify(new ItemNextedNotification($item));
			break;
			case $event instanceof ItemStartedEvent:
				$user->notify(new ItemStartedNotification($item));
			break;
		}
    }
}
