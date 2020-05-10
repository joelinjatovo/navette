<?php

namespace App\Events;

use App\Models\Item;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;
    
    public $action;
    
    public $oldStatus;
    
    public $newStatus;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Item $item, $action, $oldStatus, $newStatus)
    {
        $this->item = $item;
        $this->action = $action;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('App.User.'.$this->item->order->user->getKey()),
            new PrivateChannel('App.Item.'.$this->item->getKey())
        ];
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'item.'.$this->action;
    }
    
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'item_id' => $this->item->getKey(),
            'ride_at' => $this->item->ride_at,
            'order_id' => $this->item->order?$this->item->order->getKey():null,
            'user_id' => $this->item->order&&$this->item->order->user?$this->item->order->user->getKey():null,
            'oldStatus' => $this->oldStatus,
            'newStatus' => $this->newStatus,
        ];
    }
}
