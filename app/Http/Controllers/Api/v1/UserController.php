<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiStoreUser as StoreUserRequest;
use App\Http\Requests\ApiUpdateUser as UpdateUserRequest;
use App\Http\Requests\VerifyPhone as VerifyPhoneRequest;
use App\Http\Requests\RateUser as RateUserRequest;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserItem as UserItemResource;
use App\Http\Resources\UserCollection;
use App\Models\AccessToken;
use App\Models\Note;
use App\Models\User;
use App\Models\Role;
use App\Models\RefreshToken;
use App\Repositories\TokenRepository;
use App\Services\ImageUploader;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    
    private $uploader;
    
    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Show logged in user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        return new UserResource($request->user()->load('roles'));
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
            'first_name' => $data['first_name']??null,
            'last_name' => $data['last_name']??null,
            'birthday' => $data['birthday']??null,
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
		
		$customer = \Stripe\Customer::create([
			'name' => $user->name,
			'email' => $user->email,
			'phone' => $user->phone,
		]);
        
        if($customer){
            $user->stripe_id = $customer->id;
            $user->save();
        }

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
            'payment_method_id' => $data['payment_method_id']??null,
            'first_name' => $data['first_name']??null,
            'last_name' => $data['last_name']??null,
            'birthday' => $data['birthday']??null,
            'phone' => $data['phone']??null,
            'email' => $data['email']??null,
        ]);
        
        $token = app('api_token');

        return (new AccessTokenResource($token));
    }

    /**
     * Upload avatar photo
     *
     * @return Response
     */
    public function avatar(Request $request)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg'
        ]);
        
        $user = $request->user();
        
        $this->uploader->upload('image', $user);
        
        $token = app('api_token');

        return (new AccessTokenResource($token));
    }

    /**
     * Rate driver
     *
     * @param RateUserRequest $request
     * 
     * @return Response
     */
    public function rate(RateUserRequest $request)
    {
        $driver = User::findOrFail($request->input('id'));
        $star = $request->input('star');
		
		$note = new Note();
		$note->type = Note::TYPE_REVIEWS;
		$note->star = $star;
		
		$driver->notes()->save($note);
        
        return $this->success(200, trans('messages.driver.rated'));
    }
}
