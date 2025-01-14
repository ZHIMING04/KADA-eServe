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

    //Define abilities

    Bouncer::ability()->firstOrCreate([
        'name' => 'apply-loan',
        'title' => 'Apply Loan',
    ]);

    Bouncer::ability()->firstOrCreate([
        'name' => 'view-individual-report',
        'title' => 'View Individual Report',
    ]);

    Bouncer::ability()->firstOrCreate([
        'name' => 'approve-member-registration',
        'title' => 'Approve Member Registration',
    ]);

    Bouncer::ability()->firstOrCreate([
        'name' => 'approve-loan',
        'title' => 'Approve Loan',
    ]);

    //Assign abilities to roles
    Bouncer::allow('member')->to('apply-loan');
    Bouncer::allow('member')->to('view-individual-report');
    Bouncer::allow('admin')->to('approve-member-registration');
    Bouncer::allow('admin')->to('approve-loan');

    }
}
