<?php

namespace App\Events\RidePoint;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RidePointDriverArrived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ridepoint;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\RidePoint $ridepoint)
    {
        $this->ridepoint = $ridepoint;
    }
}
