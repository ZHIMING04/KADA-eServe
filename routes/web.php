<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\MemberController;
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // ... other authenticated routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('loans', LoanController::class);
});

Route::get('/register', [MemberController::class, 'create'])->name('register-member.create');
Route::post('/register', [MemberController::class, 'store'])->name('register-member.store');

Route::get('/loan', [LoanController::class, 'create'])->name('loan.create');
Route::post('/loan', [LoanController::class, 'store'])->name('loan.store');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/dashboard/member', [DashboardController::class, 'member'])->name('dashboard.member');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

