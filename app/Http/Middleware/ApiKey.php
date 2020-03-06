<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ApiKeyModel;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;

class ApiKey
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
        $token = $request->header('x-api-key');
        if( empty($token) || !$this->isValidApiKey($token)){
            return response()->json([
                'code' => 403,
                'status' => 'Forbidden',
                'data' => null
            ], 403);
        }
        
        return $next($request);
    }
    
    private function isValidApiKey($token){
        try {
            $decrypted = decrypt($token);
        } catch (DecryptException $e) {
            return false;
        }
        return null != ApiKeyModel::where('scopes', $decrypted)->where('revoked', 0)->where('expires_at', '>', now())->first();
    }
}
