<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Ride;

class RideChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, Ride $ride)
    {
        return true; //$user->canJoinRide($ride->getKey());
    }
}
