<?php

namespace App\Providers;

use Cookie;
use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\LaravelDebugbar as Debugbar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') == 'production') {
            (new Debugbar)->disable();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
