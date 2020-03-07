<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Travel;

class TravelChannel
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
    public function join(User $user, Travel $travel)
    {
        return true; //$user->canJoinTravel($travel->id);
    }
}
