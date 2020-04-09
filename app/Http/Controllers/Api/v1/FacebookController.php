<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Models\User;
use App\Repositories\TokenRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacebookController extends Controller
{
    /**
     * Facebook connect
     *
     * @param  Request  $request
     * @return Response
     */
    public function connect(Request $request, TokenRepository $repository)
    {
        $user = User::where('phone', $request->input('phone'))->first();
        if (!$user) {
            $user = User::where('email', $request->input('email'))->first();
        }
        if (!$user) {
            $user = User::where('facebook_id', $request->input('facebook_id'))->first();
        }
        
        if (!$user) {
            $user = User::create([
                'facebook_id' => $request->input('facebook_id'),
                'phone' => $request->input('phone'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => '123',
            ]);
        
            $user->sendPhoneVerificationNotification();

            event(new Registered($user));
        }else{
            $user->facebook_id = $request->input('facebook_id');
            $user->save();
        }

        $token = $repository->generateToken($user);

        return (new AccessTokenResource($token));
    }
      
}
