<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\IndividualReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\MemberController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\FinanceController;

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


Route::get('/guest/register', [MemberController::class, 'create'])->name('guest.register');
Route::post('/guest/register', [MemberController::class, 'store'])->name('guest.register.store');
Route::get('/loan', [LoanController::class, 'create'])->name('loan.create');
Route::post('/loan', [LoanController::class, 'store'])->name('loan.store');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/guest/success', function () {
    return view('guest.success');
})->name('guest.success');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [AdminMemberController::class, 'show'])->name('members.show');
    Route::get('/members/{member}/edit', [AdminMemberController::class, 'edit'])->name('members.edit');
    Route::delete('/members/{member}', [AdminMemberController::class, 'destroy'])->name('members.destroy');
});

