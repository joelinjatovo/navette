<?php

namespace App\Providers;

use App\Models\User;
use App\Models\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('api-token', function ($request) {
            $bearerToken = substr($request->header('Authorization'), strlen('Bearer '));
            $token = AccessToken::where('scopes', $bearerToken)
                    ->where('revoked', 0)
                    ->whereDate('expires_at', '>', date('Y-m-d H:i:s'))
                    ->first();
            
            $this->app->singleton('api_token', function($app) use ($token) {
                return $token;
            });
            
            if( null != $token ) {
                return $token->user;
            }
        });
    }
}
