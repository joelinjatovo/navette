<?php

namespace App\Http\Controllers\Account;

use App\Http\Resources\Success as SuccessResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VerificationController extends Controller
{

    /**
     * Show verification form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedPhone()) {
            return redirect()->route('shop.order')->with('info', trans("Phone Already Verified"));
        }

        return view('customer.account.verify');
    }

    /**
     * Mark the authenticated user's phone number as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedPhone()) {
            return redirect()->route('shop.order')->with('info', trans("Phone Already Verified"));
        }
		
		if($request->input('action') == 'resend' ){
			return $this->resend($request);
		}
		
		if (!$user->isValidCode($request->input('code'))){
			return back()->with('error', trans("Invalid Verification Code"));
		}

		if ($user->markPhoneAsVerified()) {
			event(new Verified($user));
		}

		return redirect()->route('shop.order')->with('success', trans("Phone Verified"));
    }

    /**
     * Resend the phone verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasVerifiedPhone()) {
            return redirect()->route('shop.order')->with('info', trans("Phone Already Verified"));
        }

        $user->sendPhoneVerificationNotification();
		
		return back()->with('success', trans("Verification Code Sent"));
    }
}
