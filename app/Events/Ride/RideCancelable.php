<?php

namespace App\Events\Ride;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideCancelable
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Ride $ride)
    {
        $this->ride = $ride;
    }
}
