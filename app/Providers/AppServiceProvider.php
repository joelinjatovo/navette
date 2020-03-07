<?php

namespace App\Providers;

use App\Http\Middleware\AccessLog;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // share key to all view blade file
        View::share('key', 'value');
        
        // Do not wrapped JSon data
        JsonResource::withoutWrapping();
        
        // Log access
        $this->app->singleton(AccessLog::class);
        
    }
}
