<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Item;

class ItemChannel
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
     * @param  \App\Models\Item  $item
     * @return array|bool
     */
    public function join(User $user, Item $item)
    {
        return true; //$item->order && $item->order->user && ($user->getKey() == $item->order->user->getKey());
    }
}
