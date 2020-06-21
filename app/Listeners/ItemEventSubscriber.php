<?php

namespace App\Listeners;

use App\Models\Item;

use App\Events\Item\ItemActived as ItemActivedEvent;
use App\Events\Item\ItemCanceled as ItemCanceledEvent;
use App\Events\Item\ItemCompleted as ItemCompletedEvent;
use App\Events\Item\ItemDeleted as ItemDeletedEvent;
use App\Events\Item\ItemDetached as ItemDetachedEvent;
use App\Events\Item\ItemPartialyCanceled as ItemPartialyCanceledEvent;
use App\Events\Item\ItemPartialyCompleted as ItemPartialyCompletedEvent;
use App\Events\Item\ItemReceived as ItemReceivedEvent;

use App\Notifications\ItemActived as ItemActivedNotification;
use App\Notifications\ItemCanceled as ItemCanceledNotification;
use App\Notifications\ItemCompleted as ItemCompletedNotification;
use App\Notifications\ItemDeleted as ItemDeletedNotification;
use App\Notifications\ItemDetached as ItemDetachedNotification;
use App\Notifications\ItemPartialyCanceled as ItemPartialyCanceledNotification;
use App\Notifications\ItemPartialyCompleted as ItemPartialyCompletedNotification;
use App\Notifications\ItemReceived as ItemReceivedNotification;

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
        $events->listen(ItemDeletedEvent::class, self::class .'@handle');
        $events->listen(ItemDetachedEvent::class, self::class .'@handle');
        $events->listen(ItemPartialyCanceledEvent::class, self::class .'@handle');
        $events->listen(ItemPartialyCompletedEvent::class, self::class .'@handle');
        $events->listen(ItemReceivedEvent::class, self::class .'@handle');
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
			case $event instanceof ItemDeletedEvent:
				$user->notify(new ItemDeletedNotification($item));
			break;
			case $event instanceof ItemDetachedEvent:
				$user->notify(new ItemDetachedNotification($item));
			break;
			case $event instanceof ItemPartialyCanceledEvent:
				$user->notify(new ItemPartialyCanceledNotification($item));
			break;
			case $event instanceof ItemPartialyCompletedEvent:
				$user->notify(new ItemPartialyCompletedNotification($item));
			break;
			case $event instanceof ItemReceivedEvent:
				$user->notify(new ItemReceivedNotification($item));
			break;
		}
    }
}
