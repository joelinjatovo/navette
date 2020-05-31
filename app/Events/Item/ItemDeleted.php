<?php

namespace App\Events\Item;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Item $item)
    {
        $this->item = $item;
    }
}
