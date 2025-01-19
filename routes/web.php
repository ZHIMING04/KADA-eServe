<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\IndividualReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Auth\MemberController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');

    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::get('/profile/show', 'show')->name('profile.show');
    });

    // Loans and reports
    
    Route::resource('loans', LoanController::class);
    Route::get('/report', [IndividualReportController::class, 'display'])->name('report.display');
    Route::get('/report/export', [IndividualReportController::class, 'export'])->name('report.export');

    

    // Loan Routes
    Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan/store', [LoanController::class, 'store'])->name('loan.store');
    Route::get('/loan/success', [LoanController::class, 'success'])->name('loan.success');
});

// Admin routes
Route::middleware(['auth', 'can:access-admin-dashboard'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard');

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
        Route::get('/admin/registrations/pending', 'pendingRegistrations')->name('admin.registrations.pending');
        Route::get('/admin/registrations/{id}/show', 'showRegistration')->name('admin.registrations.show');
        Route::get('/admin/members/{member}/loans', 'getMemberLoans')->name('admin.members.loans');
        Route::post('/admin/members/{member}/transaction', 'addTransaction')->name('admin.members.transaction');
    });
});

// Add new admin loan management routes
Route::middleware(['auth', 'can:manage-loans'])->group(function () {
    // Finance/Loan management routes
    Route::controller(FinanceController::class)
        ->prefix('admin/finance')
        ->name('admin.finance.')
        ->group(function () {
            // Basic CRUD operations
            Route::get('/', 'index')->name('index');                    
            Route::get('/{loanId}', 'show')->name('show');               
            Route::get('/{loanId}/edit', 'edit')->name('edit');          
            Route::put('/{loanId}', 'update')->name('update');           
            Route::delete('/{loanId}', 'destroy')->name('destroy');      
            
            // Loan approval operations - Make sure all route parameters match
            Route::post('/{loanId}/approve', 'approve')->name('approve'); 
            Route::post('/{loanId}/reject', 'reject')->name('reject');   
            
            // Export functionality
            Route::get('/export', 'export')->name('export');           
    });
});

Route::middleware(['auth', 'can:approve-member-registration'])->group(function () {
    Route::post('/admin/registrations/{id}/approve', [AdminMemberController::class, 'approve'])
        ->name('admin.registrations.approve');
    Route::post('/admin/registrations/{id}/reject', [AdminMemberController::class, 'reject'])
        ->name('admin.registrations.reject');
});

Route::post('/admin/members/batch-transaction', [AdminMemberController::class, 'batchTransaction'])
    ->name('admin.members.batch-transaction');

    Route::post('send-mail', function (Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        $details = [
            'title' => 'Success',
            'content' => 'This is an email testing using Laravel-Brevo',
        ];
    
        return back()->with('success', 'Email sent at ' . now());
    })->name('send.mail');


// Add this route with auth and verified middleware
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);


