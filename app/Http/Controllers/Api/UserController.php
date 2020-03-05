<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the list of all user
     *
     * @return Response
     */
    public function index()
    {
        return new UserCollection(User::paginate());
    }

    /**
     * Get information for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

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

        return response()->json([
            'code'    => 200,
            'status'  => "success",
            'data'    => $user,
        ]);
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

        return response()->json([
            'code'    => 200,
            'status'  => "success",
            'data'    => $user,
        ]);
    }

    /**
     * Delete the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function delete(User $user)
    {
        $user->delete();

        return response()->json([
            'code' => 200,
            'status'  => "success",
        ]);
    }
}
