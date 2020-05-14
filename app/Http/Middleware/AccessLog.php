<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ApiKeyModel;
use App\Models\AccessLog as AccessLogModel;
use App\Services\GeoIpService;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;

class AccessLog
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
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Store the session data...
        AccessLogModel::create([
                'user_id' => $request->user()?$request->user()->getKey():null,
                'url' => $request->url(),
                'status' => $response->status(),
                'method' => $request->method(),
                'referer' => $request->headers->get('referer'),
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip(),
                'platform' => $this->getPlatform($request, $response),
                'country' => $this->getCountry($request, $response),
                'api' => $request->is('api/*'),
                'api_key_id' => $this->getApiKeyId($request, $response),
            ]);
    }

    protected function getPlatform($request, $response)
    {
        $platform = 'Unknown';
        $user_agent = $request->header('User-Agent');

        //First get the platform?
        if (preg_match('/linux/i', $user_agent)) {
            $platform = 'linux';
        }elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'mac';
        }elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'windows';
        }elseif (preg_match('/android/i', $user_agent)) {
            $platform = 'android';
        }elseif (preg_match('/ios/i', $user_agent)) {
            $platform = 'ios';
        }

        return $platform;
    }

    protected function getCountry($request, $response)
    {
        return null;
    }
    
    protected function getApiKeyId($request, $response){
        $token = $request->header('x-api-key');
        
        if( empty($token) ) {
            return null;
        }
        
        try {
            $decrypted = decrypt($token);
        } catch (DecryptException $e) {
            return null;
        }
        
        $api = ApiKeyModel::where('scopes', $decrypted)
                ->where('revoked', 0)
                ->where('expires_at', '>', date('Y-m-d H:i:s'))
                ->first();
        
        if( null != $api ) {
            return $api->id;
        }
        
        return null;
    }
}
