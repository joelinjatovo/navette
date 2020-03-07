<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPosition as StoreUserPositionRequest;
use App\Http\Resources\UserPosition as UserPositionResource;
use App\Models\User;
use App\Models\UserPosition;
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

        $position = $request->user()->positions()->create($validated);

        return new UserPositionResource($position);
    }
}
