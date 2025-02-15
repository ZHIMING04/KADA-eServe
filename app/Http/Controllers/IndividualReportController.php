<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class IndividualReportController extends Controller
{
    public function display(Request $request)
    {
        // Get member with latest status based on email
        $member = DB::table('member_register as m1')
            ->select('m1.*')
            ->where('m1.email', auth()->user()->email)
            ->whereNotExists(function ($query) {
                $query->from('member_register as m2')
                      ->whereRaw('m1.email = m2.email')
                      ->whereRaw('m1.updated_at < m2.updated_at');
            })
            ->first();

        // Load the full member model with relationships
        $member = Member::with(['workingInfo', 'familyMembers', 'savings'])
            ->where('id', $member->id)
            ->first();

        // Remove any resignation-related checks or messages here

        // Simplified transaction query
        $transactionsQuery = DB::table('member_transactions')
            ->select('member_transactions.*')
            ->where('member_transactions.member_id', $member->id);
        
        // Apply sorting based on the request
        if ($request->filled('month') && $request->filled('year')) {
            $transactionsQuery->whereMonth('member_transactions.created_at', $request->month)
                            ->whereYear('member_transactions.created_at', $request->year);
        }
   
        $transactions = $transactionsQuery->orderBy('member_transactions.created_at', 'desc')
            ->paginate(7)
            ->through(function ($transaction) {
                // Transform the transaction type display
                $transaction->type_display = match($transaction->type) {
                    'savings' => 'Simpanan',
                    'loan' => 'Bayar Balik',
                    default => $transaction->type
                };

                // Format the reference based on transaction type
                if ($transaction->type == 'loan') {
                    // Get the loan details
                    $loan = DB::table('loans')
                        ->where('loan_id', $transaction->loan_id)
                        ->first();
                    
                    $transaction->reference = $loan ? 'LOAN-' . $loan->loan_id : '-';
                } else if ($transaction->type == 'savings') {
                    // Map savings types to their display names
                    $savingsTypeMap = [
                        'share_capital' => 'MS',          // Modal Syer
                        'subscription_capital' => 'MY',    // Modal Yuran
                        'member_deposit' => 'DA',         // Deposit Ahli
                        'welfare_fund' => 'TK',           // Tabung Kebajikan
                        'fixed_savings' => 'ST'           // Simpanan Tetap
                    ];
                    
                    $prefix = $savingsTypeMap[$transaction->savings_type] ?? 'S';
                    $transaction->reference = $prefix . '-' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT);
                } else {
                    $transaction->reference = '-';
                }

                return $transaction;
            });

        // Get other data
        $loans = DB::table('loans')->where('member_id', $member->id)->get();
        $loans = $loans->map(function ($loan) {
            $loan->loan_type = DB::table('loan_types')->where('loan_type_id', $loan->loan_type_id)->first();
            return $loan;
        });

        $saving = DB::table('savings')->where('no_anggota', $member->id)->first();
        $totalSavings = $this->calculateTotalSaving($saving);

        return view('individualReport.report', compact('member', 'loans', 'saving', 'totalSavings', 'transactions'));
    }


    private function calculateTotalSaving($saving)
    {
        return $saving->share_capital + $saving->subscription_capital + $saving->welfare_fund + $saving->fixed_savings + $saving->member_deposit;
    }
  

    public function export(Request $request){
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
 
        $loans = DB::table('loans')->where('member_id',$member->id)->get();

        $loans = $loans->map(function ($loan) {
            $loan->loan_type = DB::table('loan_types')->where('loan_type_id', $loan->loan_type_id)->first();
            return $loan;
        });

        $saving = DB::table('savings')->where('no_anggota',$member->id)->first();

        $totalSavings=$this->calculateTotalSaving($saving);

        // Generate PDF
        $pdf = PDF::loadView('individualReport.exportpdf',compact('member','loans','saving','totalSavings'));

        // Download PDF file
        return $pdf->download('Laporan-Individu-'.$member->no_anggota.'.pdf');

    }

    public function exportTransactions(Request $request)
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();

        // Simplified transaction query
        $transactionsQuery = DB::table('member_transactions')
            ->select('member_transactions.*')  // Select all from transactions
            ->where('member_transactions.member_id', $member->id);
            
        // Apply sorting based on the request
        if ($request->filled('month') && $request->filled('year')) {
            $transactionsQuery->whereMonth('member_transactions.created_at', $request->month)
                              ->whereYear('member_transactions.created_at', $request->year);
        }

        $transactions = $transactionsQuery->orderBy('member_transactions.created_at', 'desc')->get();

        $transactions->each(function ($transaction) {
            if ($transaction->type == 'loan') {
                $loan = DB::table('loans')->where('loan_id', $transaction->loan_id)->first();
                if ($loan) {
                    $loanType = DB::table('loan_types')->where('loan_type_id', $loan->loan_type_id)->first();
                    $transaction->loan_type = $loanType ? $loanType->loan_type : null;
                }
            }
        });

        // Generate PDF
        $pdf = PDF::loadView('individualReport.exportTransactions', compact('member', 'transactions'));

        // Download PDF file
        return $pdf->download('Laporanan Transaksi - '.$member->no_anggota.'.pdf');
    }

    
}

