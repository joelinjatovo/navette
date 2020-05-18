<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Image;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        return view('account.show', ['user' => $request->user()]);
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
        
        if ($request->hasFile('profile.image')) {
            $file = $request->file('profile.image');
            if ($file->isValid()) {
                $name = md5(time()).'.'.$file->extension();
                $path = $file->storeAs('uploads',  'users/' . $request->user()->getKey() . '/' . $name);
                
                $image = new Image([
                    'url' => $path, 
                    'type' => $file->getClientMimeType(), 
                    'name' => $file->getClientOriginalName()
                ]);
                
                $request->user()->image()->save($image);
            }
        }
        
        return back()->with("success", "Votre profil a été bien mis à jour.");
    }
}
