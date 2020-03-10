<?php

namespace App\Providers;

use App\Http\Middleware\AccessLog as AccessLogMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

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
        // String DB Lengths
        Schema::defaultStringLength(191);
        
        // share key to all view blade file
        View::share('key', 'value');
        
        // Do not wrapped JSon data
        JsonResource::withoutWrapping();
        
        // Log access
        $this->app->singleton(AccessLogMiddleware::class);
        
        $this->app->bind(\App\Services\ProcessorInterface::class, \App\Services\TravelProcessor::class);
        
    }
}
