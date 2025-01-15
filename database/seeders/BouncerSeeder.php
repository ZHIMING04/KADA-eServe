<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    public function run()
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
            'name' => 'access-admin-dashboard',
            'title' => 'Access Admin Dashboard',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'manage-members',
            'title' => 'Manage Members',
        ]);

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

        // Add new loan management abilities
        Bouncer::ability()->firstOrCreate([
            'name' => 'manage-loans',
            'title' => 'Manage Loans',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'view-all-loans',
            'title' => 'View All Loans',
        ]);

        // Assign abilities to roles
        Bouncer::allow('admin')->to('access-admin-dashboard');
        Bouncer::allow('admin')->to('manage-members');
        Bouncer::allow('admin')->to('manage-loans');
        Bouncer::allow('admin')->to('view-all-loans');
        Bouncer::allow('admin')->to('approve-member-registration');
        Bouncer::allow('admin')->to('approve-loan');

        Bouncer::allow('member')->to('apply-loan');
        Bouncer::allow('member')->to('view-individual-report');

        // ... rest of your role and ability creation logic ...
    }
} 