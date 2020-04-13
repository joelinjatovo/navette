<?php

namespace App\Http\Controllers\Api\v1;

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
     * Mark the authenticated user's phone number as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = $request->user();
        
        if (!$user->isValidCode($request->input('code'))){
            return $this->error(400, 108, "Invalid Verification Code");
        }

        if ($user->hasVerifiedPhone()) {
            return $this->error(400, 109, "Phone Already Verified");
        }

        if ($user->markPhoneAsVerified()) {
            event(new Verified($user));
        }
        
        $token = app('api_token');

        return (new AccessTokenResource($token));
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
            throw new AuthorizationException;
        }

        $user->sendPhoneVerificationNotification();

        return $this->success(200, "Verification Code Sent");
    }
}
