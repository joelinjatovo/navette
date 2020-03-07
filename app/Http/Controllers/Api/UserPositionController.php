<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPosition as StoreUserPositionRequest;
use App\Http\Resources\UserPosition as UserPositionResource;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Models\UserPosition;
use App\Models\Point;
use Illuminate\Http\Request;

class UserPositionController extends Controller
{
    
    /**
     * Store a new user postion.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserPositionRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = $request->user();
        $point = Point::create($validated);
        $user->positions()->attach($point->id, ['created_at' => now()]);
        
        event(new \App\Events\UserPositionCreated($user, $point));
        event(new \App\Events\TravelUserPositionCreated($user, $point));

        return new UserResource($user);
    }
}
