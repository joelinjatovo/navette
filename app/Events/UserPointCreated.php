<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPointCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $point;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\User $user, \App\Models\Point $point)
    {
        $this->user = $user;
        $this->point = $point;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        $channels[] = new PrivateChannel('App.User.'.$this->user->getKey());
        $ride = $this->user->ridesDrived()
            ->orWhere('rides.status', \App\Models\Ride::STATUS_STARTED)
            ->orWhere('rides.status', \App\Models\Ride::STATUS_PING)
			->first();
        if($ride){
            $channels[] = new PrivateChannel('App.Ride.'.$ride->getKey());
        }
        return $channels;
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'user.point.created';
    }
    
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'point' => [
                'name' => $this->point->name,
                'lat' => $this->point->lat,
                'lng' => $this->point->lng,
                'alt' => $this->point->alt,
            ],
        ];
    }
}
