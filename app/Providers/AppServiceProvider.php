<?php

namespace Rulla\Providers;

use Illuminate\Support\ServiceProvider;
use Rulla\Authentication\AuthenticationManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(AuthenticationManager::class, new AuthenticationManager());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
