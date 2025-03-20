<?php

namespace App\Providers;

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
        /*
        There’s a bug in Laravel 5.4 if you’re running a version of MySQL older than 5.7.7 or MariaDB
        older than 10.2.2. More info here. This can be fixed by replacing the boot() of
        app/Providers/AppServiceProvider.php with:
        */
        //Schema::defaultStringLength(191);
    }
}
