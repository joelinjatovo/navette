<?php

namespace App\Events;

use App\Models\Travel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TravelUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $travel;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Travel $travel)
    {
        $this->travel = $travel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.Travel.'.$this->travel->id);
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'travel.updated';
    }
    
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    /*
    public function broadcastWith()
    {
        return ['id' => $this->travel->id];
    }
    */
}
