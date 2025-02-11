<?php

// Remove or comment out these lines to disable the inspire command
// use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Register the monthly interest command here as well
Artisan::command('monthly:interest', function () {
    $this->call('monthly:interest');
})->describe('Process monthly interest for loans and savings');
