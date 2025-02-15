<?php

namespace App\Http\Controllers\Admin;
namespace App\Mail;

use App\Http\Controllers\Controller;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Notifications\LoanRejected;
use App\Mail\MailLoanReject;

class LoanController extends Controller
{
    public function reject(Request $request, $loanId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        try {
            $loan = Loan::with('member.user')->findOrFail($loanId);
            
            // Log loan and member details
            Log::info('Loan rejection process started', [
                'loan_id' => $loan->loan_id,
                'member_id' => $loan->member_id,
                'member_exists' => $loan->member ? 'yes' : 'no',
                'user_exists' => $loan->member && $loan->member->user ? 'yes' : 'no'
            ]);

            if (!$loan->member) {
                throw new \Exception('Member not found for loan');
            }

            if (!$loan->member->user) {
                throw new \Exception('User not found for member');
            }

            DB::transaction(function () use ($loan, $request) {
                // Update loan status
                $loan->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                    'rejected_at' => now(),
                    'rejected_by' => auth()->id()
                ]);

                try {
                    // Get the user's email
                    $userEmail = $loan->member->user->email;

                    Log::info('Attempting to send rejection email', [
                        'loan_id' => $loan->loan_id,
                        'email' => $userEmail,
                        'member_name' => $loan->member->name
                    ]);

                    // Send email
                    Mail::to($userEmail)
                        ->send(new MailLoanReject($loan, $request->rejection_reason));

                    Log::info('Loan rejection email sent successfully', [
                        'loan_id' => $loan->loan_id,
                        'email' => $userEmail
                    ]);

                } catch (\Exception $e) {
                    Log::error('Failed to send loan rejection email', [
                        'loan_id' => $loan->loan_id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            });

            return redirect()->route('admin.finance.index')
                ->with('success', 'Permohonan pinjaman telah ditolak dan notifikasi telah dihantar kepada pemohon.');

        } catch (\Exception $e) {
            Log::error('Loan rejection process failed', [
                'loan_id' => $loanId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.finance.index')
                ->with('error', 'Gagal menolak permohonan pinjaman: ' . $e->getMessage());
        }
    }
}