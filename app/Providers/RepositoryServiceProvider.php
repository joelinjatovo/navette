<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider implements ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\BaseRepository',
            'App\Repositories\UserRepository'
        );
    }
}
