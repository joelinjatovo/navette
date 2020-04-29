<?php

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\ItemChannel;
use App\Broadcasting\OrderChannel;
use App\Broadcasting\RideChannel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->getKey() === (int) $id;
});
Broadcast::channel('App.Item.{item}', ItemChannel::class);
Broadcast::channel('App.Order.{order}', OrderChannel::class);
Broadcast::channel('App.Ride.{ride}', RideChannel::class);
