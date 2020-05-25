<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\AuthorizationException;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class VerificationController extends Controller
{

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
		$request->session()->forget('token');
		
		$phone = $request->session()->get('phone', null);
		
		if(empty($phone)){
			return redirect()->route('password.phone');
		}
        
		return view('auth.passwords.verify', ['phone' => $phone]);
    }

    /**
     * Mark the authenticated user's phone as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $request->validate([
			'phone' => 'required|numeric|exists:users,phone|exists:password_tokens,phone',
			'code' => 'required|numeric|between:999,10000'
		]);
		
		$token = PasswordToken::where('phone', $request->input('phone'))
					->where('code', md5($request->input('code')))
					->where('updated_at', '>', Carbon::now()->subSeconds(Config::get('auth.password_timeout', 3600)))
					->first();
		if(!$token){
        	return back()->with('error', trans('Code de verification invalide'));
		}
		
		$user = User::where('phone', $request->input('phone'))->first();
		if(!$user){
        	return back()->with('error', trans('Compte utilisateur introuvable'));
		}
			
		$request->session()->put('code', $request->input('code'));
		
		return redirect()->route('password.reset')->with('verified', true);
    }
}
