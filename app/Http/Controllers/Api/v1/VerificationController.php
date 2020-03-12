<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\Success as SuccessResource;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
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
        if (!$request->user()->isValidCode($request->input('code'))){
            abort(400, 'Bad Request');
        }

        if ($request->user()->hasVerifiedPhone()) {
            throw new AuthorizationException;
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
            throw new AuthorizationException;
        }

        $request->user()->sendPhoneVerificationNotification();

        return new SuccessResource(null);
    }
}
