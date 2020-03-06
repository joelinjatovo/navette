<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ApiKeyModel;
use Closure;

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
        if( empty($apikey) || !$this->isValidApiKey($token)){
            return response()->json([
                'code' => 403,
                'status' => 'Forbidden',
                'data' => null
            ], 403);
        }
        
        return $next($request);
    }
    
    private function isValidApiKey($token){
        return false; //null != ApiKeyModel::where('scopes', $token)->andWhere('revoked', 0)->andWhere('expires_at', '>', now())->first();
    }
}
