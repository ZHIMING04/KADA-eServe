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

// Guest routes (for authenticated users with guest role)
Route::middleware(['auth'])->group(function () {
    Route::get('/guest/dashboard', function () {
        return view('guest.dashboard');
    })->name('guest.dashboard');

    Route::get('/guest/register', [MemberController::class, 'create'])->name('guest.register');
    Route::post('/guest/register', [MemberController::class, 'store'])->name('guest.register.store');
    Route::get('/guest/success', function () {
        return view('guest.success');
    })->name('guest.success');
});

//Member routes
Route::middleware(['auth', 'can:apply-loan'])->group(function () {
    
    // Dashboard
    Route::get('member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');

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
Route::middleware(['auth', 'can:approve-loan'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Member management
    Route::controller(AdminMemberController::class)->group(function () {
        Route::get('/admin/members', 'index')->name('admin.members.index');
        Route::get('/admin/members/create', 'create')->name('admin.members.create');
        Route::post('/admin/members', 'store')->name('admin.members.store');
        Route::delete('/admin/members/batch-delete', 'batchDelete')->name('admin.members.batch-delete');
        Route::get('/admin/members/export', 'export')->name('admin.members.export');
        Route::get('/admin/members/{member}', 'show')->name('admin.members.show');
        Route::get('/admin/members/{member}/edit', 'edit')->name('admin.members.edit');
        Route::put('/admin/members/{member}', 'update')->name('admin.members.update');
        Route::delete('/admin/members/{member}', 'destroy')->name('admin.members.destroy');
        Route::post('/admin/promote/{user}', 'promote')->name('admin.promote');
        Route::get('/admin/registrations/pending', 'pendingRegistrations')
            ->name('admin.registrations.pending');
    });
});



