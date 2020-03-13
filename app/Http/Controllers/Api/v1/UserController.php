<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Http\Requests\VerifyPhone as VerifyPhoneRequest;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\AccessToken;
use App\Models\User;
use App\Models\RefreshToken;
use App\Repositories\TokenRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * Show logged in user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserRequest $request, TokenRepository $repository)
    {
        $data = $request->validated();
        
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
        
        $user->sendPhoneVerificationNotification();
        
        event(new Registered($user));

        $token = $repository->generateToken($user);

        return (new AccessTokenResource($token));
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
        $user->update($request->validated());

        return new UserResource($user);
    }
}
