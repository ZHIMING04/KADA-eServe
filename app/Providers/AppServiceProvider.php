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
    public function boot()
    {
        // Define roles
        Bouncer::role()->firstOrCreate([
            'name' => 'guest',
            'title' => 'Guest',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'member',
            'title' => 'Member',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Admin',
        ]);

        // Define abilities
        Bouncer::ability()->firstOrCreate([
            'name' => 'fill-application-form',
            'title' => 'Fill Application Form',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'register-member',
            'title' => 'Register Member',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'promote-users',
            'title' => 'Promote Users',
        ]);

        // Assign abilities to roles
        Bouncer::allow('member')->to('fill-application-form');
        Bouncer::allow('guest')->to('register-member');
        Bouncer::allow('admin')->to('promote-users');
    }
}