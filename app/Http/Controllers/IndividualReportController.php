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
    public function display()
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
 
        // Simplified transaction query
        $transactions = DB::table('transactions')
            ->select('transactions.*')  // Select all from transactions
            ->where('transactions.member_id', $member->id)
            ->orderBy('transactions.created_at', 'desc')
            ->get()
            ->map(function ($transaction) {
                // Transform the transaction type display
                $transaction->type_display = match($transaction->type) {
                    'savings' => 'Simpanan',
                    'loan' => 'Bayar Balik',  // Changed this line
                    default => $transaction->type
                };

                // Format the reference (loan_id)
                if ($transaction->type == 'loan') {
                    // Get the loan details
                    $loan = DB::table('loans')
                        ->where('loan_id', $transaction->loan_id)
                        ->first();
                    
                    $transaction->reference = $loan ? 'LOAN-' . $loan->loan_id : '-';
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

}

