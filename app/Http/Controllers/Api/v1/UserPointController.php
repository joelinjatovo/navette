<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPoint as StoreUserPointRequest;
use App\Http\Resources\UserPoint as UserPointResource;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Models\UserPosition;
use App\Models\Point;
use Illuminate\Http\Request;

class UserPointController extends Controller
{
    
    /**
     * Store a new user postion.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserPointRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = $request->user();
        $point = Point::create($validated);
        $user->positions()->attach($point->id, ['created_at' => now()]);
        
        event(new \App\Events\UserPointCreated($user, $point));
        event(new \App\Events\TravelUserPointCreated($user, $point));

        return new UserResource($user);
    }
}
