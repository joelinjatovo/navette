<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiStoreUser as StoreUserRequest;
use App\Http\Requests\ApiUpdateUser as UpdateUserRequest;
use App\Http\Requests\VerifyPhone as VerifyPhoneRequest;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserItem as UserItemResource;
use App\Http\Resources\UserCollection;
use App\Models\AccessToken;
use App\Models\User;
use App\Models\Role;
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
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birthday' => $data['birthday'],
            'name' => $data['name'],
            'phone' => $data['phone']??null,
            'email' => $data['email']??null,
            'password' => Hash::make($data['password']),
        ]);
      
        $role = Role::where('name', Role::CUSTOMER)->first();
        if($role){
            $user->roles()->attach($role->getKey(), ['approved' => true]);
        }
		
		if(isset($data['code']) && !empty($data['code'])){
			$parent = User::where('code', $data['code'])->first();
			if($parent){
				$parent->children()->save($user);
			}
		}
        
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
    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        
        $user = $request->user();
        
        if($user->phone != $data['phone']){
            $user->sendPhoneVerificationNotification();
        }
        
        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone']??null,
            'email' => $data['email']??null,
        ]);
        
        $token = app('api_token');

        return (new AccessTokenResource($token));
    }
}
