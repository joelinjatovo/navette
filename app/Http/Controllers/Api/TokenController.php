<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            
            $token = $user->createToken(Str::random(60))
            $refresh_token = $token->createRefreshToken(Str::random(60));
            
            return response()->json([
                    'code' => 200,
                    'status' => 'Success',
                    'data' => [
                        'token' => $token->scopes,
                        'refresh_token' => $refresh_token->scopes,
                    ]
                ], 200);
        }
        
        return response()->json([
                'code' => 401,
                'status' => 'Unauthorized',
                'data' => null
            ], 401);
    }

    /**
     * Refresh the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function refresh(Request $request)
    {
        $refresh_token = RefreshToken::where('scopes', $request->refresh_token)
                    ->andWhere('revoked', 0)
                    ->andWhere('expires_at', '>', now())
                    ->first();
        
        if( ( null != $refresh_token ) && ( $user = $refresh_token->user() ) && ( $token = $refresh_token->token() ) ) {
            Auth::login($user);
            
            $refresh_token->renew();
            $token->renew(Str::random(60));
            
            return response()->json([
                    'code' => 200,
                    'status' => 'Success',
                    'data' => [
                        'token' => $token->scopes,
                        'refresh_token' => $refresh_token->scopes,
                    ]
                ], 200);
        }
        
        return response()->json([
                'code' => 401,
                'status' => 'Unauthorized',
                'data' => null
            ], 401);
    }
}