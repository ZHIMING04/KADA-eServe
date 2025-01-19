<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class LoanStatusController extends Controller
{
    public function display()
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
 
        $loans = DB::table('loans')->where('member_id',$member->id)->get();

        $loans = $loans->map(function ($loan) {
            $loan->loan_type = DB::table('loan_types')->where('loan_type_id', $loan->loan_type_id)->first();
            return $loan;
        });

         return view('loanStatus.display',compact('member','loans'));
    }

    public function show($id)
    {
        $loan = DB::table('loans')->where('loan_id', $id)->first();

        if ($loan) {
            $loan->loan_type = DB::table('loan_types')->where('loan_type_id', $loan->loan_type_id)->first();
            $loan->guarantors = DB::table('guarantors')->where('loan_id', $loan->loan_id)->get();
            $loan->bank = DB::table('banks')->where('bank_id', $loan->bank_id)->first();
        } else {
            abort(404);
        }

        return view('loanStatus.show', compact('loan'));
    }

}
