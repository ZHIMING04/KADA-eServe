<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\IndividualReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Auth\MemberController;
use App\Http\Controllers\Admin\FinanceController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Guest routes
Route::prefix('guest')->name('guest.')->group(function () {
    Route::get('/register', [MemberController::class, 'create'])->name('register');
    Route::post('/register', [MemberController::class, 'store'])->name('register.store');
    Route::get('/success', function () {
        return view('guest.success');
    })->name('success');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('guest/dashboard', function () {
        return view('guest.dashboard');
    })->name('dashboard');

    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Loans and reports
    Route::resource('loans', LoanController::class);
    Route::get('/report', [IndividualReportController::class, 'display'])->name('report.display');

    // Loan Routes
    Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan/store', [LoanController::class, 'store'])->name('loan.store');
    Route::get('/loan/success', [LoanController::class, 'success'])->name('loan.success');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Member management
    Route::controller(AdminMemberController::class)->group(function () {
        Route::get('/members', 'index')->name('members.index');
        Route::get('/members/create', 'create')->name('members.create');
        Route::post('/members', 'store')->name('members.store');
        Route::delete('/members/batch-delete', 'batchDelete')->name('members.batch-delete');
        Route::get('/members/export', 'export')->name('members.export');
        Route::get('/members/{member}', 'show')->name('members.show');
        Route::get('/members/{member}/edit', 'edit')->name('members.edit');
        Route::put('/members/{member}', 'update')->name('members.update');
        Route::delete('/members/{member}', 'destroy')->name('members.destroy');
    });

    // Add this new route
    Route::get('/registrations/pending', [AdminMemberController::class, 'pendingRegistrations'])
        ->name('registrations.pending');
});


