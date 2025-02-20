<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\IndividualReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Auth\MemberController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\LoanStatusController;
use App\Http\Controllers\MemberStatusController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\AnnualReportController;
use App\Http\Controllers\MemberTransactionController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ListController;
use App\Http\Controllers\ResignationController;
use App\Models\Resignation;
use App\Service\SmsService;
use App\Http\Controllers\Admin\MemberDataEntryController;
use Illuminate\Mail\Message;
use App\Mail\MailLoanReject;
use App\Models\Loan;



require __DIR__.'/auth.php';

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/hubungi-kami', function () {
    return view('profile.contact');
})->name('contact');

Route::get('/annual-reports', [AnnualReportController::class, 'index'])->name('annual-reports');
Route::get('/annual-report/search', [AnnualReportController::class, 'search'])->name('annual-report.search');


// Guest routes (for authenticated users with guest role)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/guest/dashboard', function () {
        return view('guest.dashboard');
    })->name('guest.dashboard');

    Route::get('/guest/status', [MemberStatusController::class, 'display'])->name('guest.status');
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
        Route::get('/profile/edit', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::get('/profile/show', 'show')->name('profile.show');
        Route::post('/profile/update-phone', 'updatePhone')->name('profile.updatePhone');
        Route::post('/profile/update-email', 'updateEmail')->name('profile.updateEmail');
        Route::post('/profile/verify-phone', 'verifyPhone')->name('profile.verifyPhone');
        Route::post('/profile/verify-email', 'verifyEmail')->name('profile.verifyEmail');
    });

    //Loan Status
    Route::get('/status', [LoanStatusController::class, 'display'])->name('loan.display');
    Route::get('/status/{id}', [LoanStatusController::class, 'show'])->name('loan.show');
    Route::get('/status/{id}/export', [LoanStatusController::class, 'export'])->name('loan.export');

    // Loans and reports
    
    Route::resource('loans', LoanController::class);
    Route::get('/report', [IndividualReportController::class, 'display'])->name('report.display');
    Route::get('/report/export', [IndividualReportController::class, 'export'])->name('report.export');
    Route::get('/report/export-transactions', [IndividualReportController::class, 'exportTransactions'])->name('individualReport.exportTransactions');


    // Loan Routes
    Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan/store', [LoanController::class, 'store'])->name('loan.store');
    Route::get('/loan/success', [LoanController::class, 'success'])->name('loan.success');

    // Member Transaction routes
    Route::controller(MemberTransactionController::class)->group(function () {
        Route::get('/member/transactions/create', 'create')->name('member.transactions.create');
        Route::post('/member/transactions/store', 'store')->name('member.transactions.store');
        Route::get('/member/transactions', 'index')->name('member.transactions.index');
        Route::get('/member/loans/active', 'getMemberLoans')
            ->name('member.loans')
            ->middleware(['auth', 'can:apply-loan']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/resignation/form', [ResignationController::class, 'showForm'])->name('resignation.form');
        Route::post('/resignation/submit', [ResignationController::class, 'submit'])->name('resignation.submit');
    });

});

// Admin routes
Route::middleware(['auth', 'can:access-admin-dashboard'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard-data', [DashboardController::class, 'getDashboardData'])->name('admin.dashboard.data');
    Route::get('/data-entry/create', [MemberDataEntryController::class, 'create'])->name('admin.data-entry.create');
    Route::post('/data-entry', [MemberDataEntryController::class, 'store'])->name('admin.data-entry.store');
    Route::get('/admin/savings-data', [DashboardController::class, 'getSavingsData'])
    ->name('admin.savings-data');


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

    // Transaction routes
    Route::get('/admin/transactions', [TransactionController::class, 'index'])
        ->name('admin.transactions.index');
    Route::get('/admin/transactions/{transactionId}', [TransactionController::class, 'show'])
        ->name('admin.transactions.show');
    Route::post('/admin/transactions/{transactionId}/approve', [TransactionController::class, 'approve'])
        ->name('admin.transactions.approve');
    Route::post('/admin/transactions/{transactionId}/reject', [TransactionController::class, 'reject'])
        ->name('admin.transactions.reject');
});

// Annual Reports routes
Route::middleware(['auth', 'can:manage-annual-reports'])->group(function () {
    Route::get('/admin/annual-reports', [AnnualReportController::class, 'adminIndex'])
        ->middleware('can:view-annual-reports')
        ->name('admin.annual-reports.index');
    Route::get('/admin/annual-reports/create', [AnnualReportController::class, 'create'])->name('admin.annual-reports.create');
    Route::post('/admin/annual-reports', [AnnualReportController::class, 'store'])->name('admin.annual-reports.store');
    Route::get('/admin/annual-reports/{report}/edit', [AnnualReportController::class, 'edit'])->name('admin.annual-reports.edit');
    Route::put('/admin/annual-reports/{report}', [AnnualReportController::class, 'update'])->name('admin.annual-reports.update');
    Route::delete('/admin/annual-reports/{report}', [AnnualReportController::class, 'destroy'])->name('admin.annual-reports.destroy');
    Route::get('/admin/annual-reports/view', [AnnualReportController::class, 'adminView'])->name('admin.annual-reports.view');
});

// Admin List Management Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/list', [ListController::class, 'index'])->name('admin.list.index');
    Route::get('/list/{id}', [ListController::class, 'view'])->name('admin.list.view');
    Route::post('/list/{id}/approve', [ListController::class, 'approve'])->name('admin.list.approve');
    Route::post('/list/{id}/reject', [ListController::class, 'reject'])->name('admin.list.reject');
    Route::get('/admin/resignation/{id}', [ListController::class, 'resign'])->name('admin.list.resign');
    // Fix the route definition
    Route::post('/list/{id}/update-status', [ListController::class, 'updateStatus'])
        ->name('admin.list.update-status');
    Route::post('/admin/resignation/{id}/approve', [ListController::class, 'approve'])->name('admin.resignation.approve');
    Route::post('/admin/resignation/{id}/reject', [ListController::class, 'reject'])->name('admin.resignation.reject');
    Route::get('resignation/{id}/reasons', [ListController::class, 'getResignationReasons'])
        ->name('admin.resignation.reasons');
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


// Remove or comment out the default verification routes
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware(['auth'])->name('verification.notice');

// Add these custom verification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        // Don't generate URL here, let the notification handle it
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        
        // Redirect based on user's role after verification
        if ($request->user()->can('access-admin-dashboard')) {
            return redirect()->route('admin.dashboard');
        } elseif ($request->user()->can('apply-loan')) {
            return redirect()->route('member.dashboard');
        } else {
            return redirect()->route('guest.dashboard');
        }
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link pengesahan telah dihantar!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Custom email verification routes for change email
Route::middleware(['auth'])->group(function () {
    Route::get('/email/change-verify', function () {
        return view('auth.verify-email');
    })->name('change.verification.notice');

    Route::get('/email/change-verify/{id}/{hash}', [ProfileController::class, 'verifyNewEmail'])
        ->middleware(['auth', 'signed'])
        ->name('change.verification.verify');

    Route::post('/email/change-verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link pengesahan telah dihantar!');
    })->middleware(['throttle:6,1'])->name('change.verification.send');
});


Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);

// Add these routes
Route::post('/admin/settings/dividend-rate', [SettingController::class, 'updateDividendRate']);
Route::post('/admin/settings/interest-rate', [SettingController::class, 'updateInterestRate']);

Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/botman/widget', function () {
    return view('vendor.botman.widget');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/member/transactions', [MemberTransactionController::class, 'store'])
        ->name('member.transactions.store');
});

Route::post('/check-member-role', [App\Http\Controllers\LoanController::class, 'checkMemberRole'])
    ->middleware(['auth'])
    ->name('check.member.role');

Route::get('/loan/validate-guarantor-pf/{pf}', [LoanController::class, 'validateGuarantorPF'])->name('loan.validate-guarantor-pf');

Route::get('/test-email', function() {
    try {
        \Log::info('Testing email configuration', [
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'from_address' => config('mail.from.address'),
        ]);

        // Assuming you have a Loan instance for testing
        $loan = Loan::first(); // Get the first loan for testing
        $rejection_reason = 'Your loan application has been rejected due to insufficient credit score.';

        // Send the custom email
        Mail::to('test@example.com')->send(new MailLoanReject($loan, $rejection_reason));

        return 'Custom email sent successfully! Check your inbox.';
    } catch (\Exception $e) {
        \Log::error('Email test failed: ' . $e->getMessage());
        return 'Email failed: ' . $e->getMessage();
    }
});

Route::get('/send-test-email', function () {
    // Assuming you have a Loan instance for testing
    $loan = Loan::first(); // Get the first loan for testing
    $rejection_reason = 'Your loan application has been rejected due to insufficient credit score.';

    // Send the test email
    Mail::to('sabrinaheng115@gmail.com')->send(new MailLoanReject($loan, $rejection_reason));

    return 'Test email sent!';
});



