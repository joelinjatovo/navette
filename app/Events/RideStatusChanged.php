<?php

namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;
    
    public $oldStatus;
    
    public $newStatus;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ride $ride, $oldStatus, $newStatus)
    {
        $this->ride = $ride;
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
        return new PrivateChannel('App.Ride.'.$this->ride->id);
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'ride.'.$this->newStatus;
    }
    
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    /*
    public function broadcastWith()
    {
        return ['id' => $this->ride->id];
    }
    */
}
