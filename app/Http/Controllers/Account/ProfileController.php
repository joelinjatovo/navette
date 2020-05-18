<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Image;
use App\Services\ImageUploader;
use Illuminate\Http\Request;

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
        
        $request->user()->fill($request->input('profile'));
        $request->user()->save();
        $this->uploader->upload('image', $request->user());
        return back()->with("success", "Votre profil a été bien mis à jour.");
    }
}
