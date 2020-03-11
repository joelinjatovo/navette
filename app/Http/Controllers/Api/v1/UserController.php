<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = User::create($validated);
        
        event(new Registered($user));
        
        return new UserResource($user);
    }

    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        $user->update($validated);

        return new UserResource($user);
    }

    /**
     * Verify user phone code
     *
     * @param  Request  $request
     * @return Response
     */
    public function verify(VerifyPhoneRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        $user->update($validated);

        return new UserResource($user);
    }
}
