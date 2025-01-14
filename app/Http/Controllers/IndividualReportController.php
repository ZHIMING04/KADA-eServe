<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\IndividualReport;
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;


class IndividualReportController extends Controller
{
    public function display()
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
 
        $loans = DB::table('loans')->where('member_id',$member->id)->get();

        $loans = $loans->map(function ($loan) {
            $loan->loan_type = DB::table('loan_types')->where('loan_type_id', $loan->loan_type_id)->first();
            return $loan;
        });

        $saving = DB::table('savings')->where('no_anggota',$member->id)->first();

        $totalSavings=$this->calculateTotalSaving($saving);

         return view('individualReport.report',compact('member','loans','saving','totalSavings'));
    }


    private function calculateTotalSaving($saving)
    {
        return $saving->share_capital + $saving->subscription_capital + $saving->welfare_fund + $saving->fixed_savings;
    }
  

}

