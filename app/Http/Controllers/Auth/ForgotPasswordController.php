<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showCodeRequestForm(Request $request)
    {
		$request->session()->forget('phone');
		
        return view('auth.passwords.phone');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetCodePhone(Request $request)
    {
		$request->session()->forget('phone');
		
        $request->validate(['phone' => 'required|numeric|exists:users,phone']);
		
		$user = User::where('phone', $request->input('phone'))->first();
		
		if($user){
			$code = "1258";
			
			PasswordToken::create([
				'phone' => $request->input('phone'),
            	'code' => md5($code),
			]);
			
			$user->notify(new \App\Notifications\ResetPassword($code));
			
			$request->session()->put('phone', $request->input('phone'));
			
			return redirect()->route('verification')
					->with('success', trans('Code sent'));
			
		}else{
			return back()
					->withInput($request->only('phone'))
					->withErrors(['phone' => trans('Code not sent')]);
		}
    }
}
