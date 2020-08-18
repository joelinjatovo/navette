<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiStoreUser as StoreUserRequest;
use App\Http\Requests\ApiUpdateUser as UpdateUserRequest;
use App\Http\Requests\VerifyPhone as VerifyPhoneRequest;
use App\Http\Requests\RateUser as RateUserRequest;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\Image as ImageResource;
use App\Http\Resources\Note as NoteResource;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserItem as UserItemResource;
use App\Http\Resources\UserCollection;
use App\Models\AccessToken;
use App\Models\Note;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;
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
        return new UserResource($request->user()->load('roles')->load('car')->load('car.club'));
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
      
		if(isset($data['role']) && !empty($data['role']) && in_array($data['role'], [Role::DRIVER, Role::CUSTOMER])){
			$role = Role::where('name', $data['role'])->first();
		}else{
			$role = Role::where('name', Role::CUSTOMER)->first();
		}
		
		if($role){
            $user->roles()->attach($role->getKey(), ['approved' => true]);
        }
		
		if($user->isCustomer()){
			$user->activated_at = now();
		}
		
		if(isset($data['code']) && !empty($data['code'])){
			$parent = User::where('code', $data['code'])->first();
			if($parent){
				$parent->children()->save($user);
			}
		}
		
		if(!empty($request->input('license_recto'))){
			$image = Image::find($request->input('license_recto'));
			if($image){
				$user->licenseRecto()->save($image);
			}
		}
		
		if(!empty($request->input('license_verso'))){
			$image = Image::find($request->input('license_verso'));
			if($image){
				$user->licenseVerso()->save($image);
			}
		}
		
		if(!empty($request->input('vtc_recto'))){
			$image = Image::find($request->input('vtc_recto'));
			if($image){
				$user->vtcRecto()->save($image);
			}
		}
		
		if(!empty($request->input('vtc_verso'))){
			$image = Image::find($request->input('vtc_verso'));
			if($image){
				$user->vtcVerso()->save($image);
			}
		}
        
        $user->sendPhoneVerificationNotification();
		
		// Remove for test
        $user->markPhoneAsVerified();
        
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
        
        $oldPhone = $user->phone;
        
        $user->update([
            'payment_method_id' => $data['payment_method_id']??null,
            'first_name' => $data['first_name']??null,
            'last_name' => $data['last_name']??null,
            'birthday' => $data['birthday']??null,
            'address' => $data['address']??null,
            'postal_code' => $data['postal_code']??null,
            'phone' => $data['phone']??null,
            'email' => $data['email']??null,
        ]);
        
        if($user->phone != $oldPhone){
            $user->sendPhoneVerificationNotification();
        }
        
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
     * Upload license photo
     *
     * @return Response
     */
    public function license(Request $request, $type)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg'
        ]);
        
        $image = $this->uploader->uploadLicense('image', $type);
        
        if($type=='verso'){
            $request->user()->licenseVerso()->save($image);
        }else{
            $request->user()->licenseRecto()->save($image);
        }
        
        $token = app('api_token');

        return (new AccessTokenResource($token));
    }

    /**
     * Upload license photo
     *
     * @return Response
     */
    public function vtc(Request $request, $type)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg'
        ]);
        
        $image = $this->uploader->uploadVTC('image', $type);
        
        if($type=='verso'){
            $request->user()->vtcVerso()->save($image);
        }else{
            $request->user()->vtcRecto()->save($image);
        }
        
        $token = app('api_token');

        return (new AccessTokenResource($token));
    }

    /**
     * Get ratings
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function ratings(Request $request)
    {
		$perpage = 5;
		if(!empty($request->perpage) && ($request->perpage > 0)){
			$perpage = $request->perpage;
		}
		$models = $request->user()->notes()
			->where('type', Note::TYPE_REVIEWS)
			->orderBy('created_at', 'desc')
			->paginate($perpage);
		
        return new NoteCollection($models);
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
