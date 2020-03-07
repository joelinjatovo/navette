<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\Unauthorized as UnauthorizedResource;
use App\Models\AccessToken;
use App\Models\RefreshToken;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /**
     * Create API token after authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function create(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        $credentials['active'] = 1;
        
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            
            $token = $user->createToken(Str::random(500));
            $refresh_token = $token->createRefreshToken(Str::random(1000));
            
            $token = AccessToken::find($token->id);
            
            return (new AccessTokenResource($token));
        }
        
        return (new UnauthorizedResource(null))->response()->setStatusCode(401);
    }

    /**
     * Refresh the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function refresh(Request $request)
    {
        $refresh_token = RefreshToken::where('scopes', $request->input('refresh_token'))
                    ->where('revoked', 0)
                    ->where('expires_at', '>', date('Y-m-d H:i:s'))
                    ->first();
        
        if( null != $refresh_token ) {
            $user = $refresh_token->user;
            if( null != $user ) {
                Auth::login($user);
                
                $token = $refresh_token->accessToken;
                if( null != $token ) {
                    $refresh_token->renew();
                    $token->renew(Str::random(500));
            
                    return (new AccessTokenResource($token));
                }
            }
        }
        
        return (new UnauthorizedResource(null))->response()->setStatusCode(401);
    }
}