<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthorizationException;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VerificationController extends Controller
{

    /**
     * Mark the authenticated user's phone number as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (md5( $request->input('code') ) != $request->user()->phone_verification_code) {
            throw new AuthorizationException;
        }
        
        if ($request->user()->phone_verification_expires_at <= Carbon::now()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedPhone()) {
            abort(400, 'Bad Request');
        }

        if ($request->user()->markPhoneAsVerified()) {
            event(new Verified($request->user()));
        }

        return new SuccessResource(null);
    }

    /**
     * Resend the phone verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedPhone()) {
            abort(400, 'Bad Request');
        }

        $request->user()->sendPhoneVerificationNotification();

        return new SuccessResource(null);
    }
}
