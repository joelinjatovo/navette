<?php

namespace App\Http\Middleware;

use App\Models\AccessToken as AccessTokenModel;
use Closure;

class AccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('x-access-token');
        if( empty($token) || !$this->isValidApiKey($token)){
            return response()->json([
                'code' => 403,
                'status' => 'forbidden',
                'data' => null
            ], 403);
        }
        
        return $next($request);
    }
    
    private function isValidApiKey($token){
        return false; //null != AccessTokenModel::where('token', $token)->first();
    }
}
