<?php

namespace App\Events\RideItem;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideItemDriverArrived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rideitem;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\RideItem $rideitem)
    {
        $this->rideitem = $rideitem;
    }
}