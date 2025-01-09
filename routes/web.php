<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\IndividualReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\MemberController;
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware(['auth'])->group(function () {
    Route::get('guest/dashboard', function () {
        return view('guest.dashboard');
    })->name('dashboard');
    // ... other authenticated routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('loans', LoanController::class);
    Route::get('/report', [IndividualReportController::class, 'display'])->name('report.display');
});

Route::get('/loan', [LoanController::class, 'create'])->name('loan.create');
Route::post('/loan', [LoanController::class, 'store'])->name('loan.store');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

