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
        $credentials = $this->credentials($request);
        
        if( ! Auth::attempt($credentials) ) {
            return $this->error(400, 1000, trans('messages.bad.credentials'));
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
        
        return $this->error(400, 1001, trans('messages.invalid.access.token'));
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
        
        $token = app('api_token');
		if($token){
			$token->delete();
		}
        
        return response()->success(200, trans('messages.logged.out'));
    }

    /**
     * Get credential from request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	protected function credentials(Request $request)
	{
		if(filter_var($request->imput('email_or_phone'), FILTER_VALIDATE_EMAIL)) {
			return [
				'email' => $request->imput('email_or_phone'), 
				'password' => $request->imput('password')
			];
		}
		
		return [
			'phone' => $request->imput('email_or_phone'),
			'password' => $request->imput('password')
		];
	}
}