<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define admin abilities
        Bouncer::allow('admin')->to('access-admin');
        Bouncer::allow('admin')->to('manage-annual-reports');
        Bouncer::allow('admin')->to('view-admin-dashboard');
    }
}
