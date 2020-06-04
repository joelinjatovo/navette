<?php

namespace App\Providers;

use App\Http\Middleware\AccessLog as AccessLogMiddleware;
use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use App\Services\GoogleApiService;
use App\Services\ImageUploader;
use App\Jobs\RideProcessor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        
        // Log all application response into database
        $this->app->singleton(AccessLogMiddleware::class);
        
        // Google API
        $this->app->singleton(GoogleApiService::class);
        
        $this->app->bind(ImageUploader::class);
		
		$this->app->bindMethod(RideProcessor::class.'@handle', function ($job, $app) {
			return $job->handle($app->make(GoogleApiService::class));
		});
        
        View::composer(['admin.car.create', 'admin.car.edit'], function ($view) {
            $view->with('drivers', User::all() /*Role::where('name', Role::DRIVER)->users*/);
            $view->with('clubs', Club::all());
        });
        
        View::composer(['shop.index'], function ($view) {
            $view->with('clubs', Club::with('point')->get());
        });
        
        View::composer(['customer.order.create', 'customer.order.edit'], function ($view) {
            $view->with('clubs', Club::with('point')->get());
        });
        
        View::composer(['admin.user.create', 'admin.user.edit'], function ($view) {
            $view->with('roles', Role::all());
        });
		
    }
}
