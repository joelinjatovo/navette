<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Image;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ProfileController extends Controller
{
    private $uploader;
    
    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }
    
    /**
     * Show the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        if($request->user()->isAdmin()){
            return view('admin.account.show', ['user' => $request->user()]);
        }
        
        return view('customer.account.show', ['user' => $request->user()]);
    }
    
    /**
     * Update the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        
        $user->fill($request->input('profile'));
		if($request->input('new_password')){
			$user->password = Hash::make($request->input('new_password'));
        	$request->user()->save();
			
			event(new PasswordReset($user));
		}
        $request->user()->save();
        $this->uploader->upload('image', $request->user());
		
        return back()->with("success", trans("Votre profil a été bien mis à jour."));
    }
    
    /**
     * Forgot password
     *
     * @param  Request  $request
     * @return Response
     */
    public function forgot(Request $request)
    {
		\Auth::logout();
        return redirect()->route('password.phone')
			->with("success", trans("Vous pouvez demander un nouveau mot de passe maintenant."));
    }
}
