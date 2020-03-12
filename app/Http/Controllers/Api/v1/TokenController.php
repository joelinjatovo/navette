<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\Unauthorized as UnauthorizedResource;
use App\Models\AccessToken;
use App\Models\RefreshToken;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\TokenRepository;
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
    public function create(Request $request, TokenRepository $repository)
    {
        $credentials = $request->only('phone', 'password');
        $credentials['active'] = 1;
        
        if( ! Auth::attempt($credentials) ) {
            abort(400, "Bad Credentials");
        }
        
        $user = Auth::user();

        $token = $repository->generateToken($user);

        return (new AccessTokenResource($token));
    }

    /**
     * Refresh the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function refresh(Request $request, TokenRepository $repository)
    {
        $refresh_token = RefreshToken::where('scopes', $request->input('refresh_token'))
                    ->where('revoked', 0)
                    ->where('expires_at', '>', date('Y-m-d H:i:s'))
                    ->first();
        
        if( ( null != $refresh_token ) && ( null != $user = $refresh_token->user) && ( null != $token = $refresh_token->accessToken ) ) {
            Auth::login($user);
            
            $token = $repository->refreshToken($token);

            return (new AccessTokenResource($token));
        }
        
        abort(400, "Invalid Refresh Token");
    }

    /**
     * Logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => null,
            ], 200);
    }
}