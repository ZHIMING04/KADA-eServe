<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;


class LoanController extends Controller
{
    public function index()
    {
        return view('loan.create');
    }

    public function create()
    {
        return view('loan.create');
    }

    public function store(Request $request)
    {
        $member_id = DB::table('members')->insertGetId([
            $name = $request->name,
            $email = $request->email,
            $ic = $request->ic,
            $phone = $request->phone,
            $address = $request->address,
            $city = $request->city,
            $postcode = $request->postcode,
            $state = $request->state,
            $office_address = $request->office_address,
            $office_city = $request->office_city,
            $office_postcode = $request->office_postcode,
        ]);

        DB::table('loans')->insert([
            'loan_id' => $request->loan_id,
            'member_id' => $member_id,
            'loan_type_id' => $request->loan_type_id,
            'bank_id' => $request->bank_id,
            'date_apply' => $request->date_apply,
            'loan_amount' => $request->loan_amount,
            'interest_rate' => $request->interest_rate,
            'monthly_repayment' => $request->monthly_repayment,
            'monthly_gross_salary' => $request->monthly_gross_salary,
            'monthly_net_salary' => $request->monthly_net_salary,
            'loan_period' => $request->loan_period,
        ]);

        DB::table('loan_types')->insert([
            'loan_type' => $request->loan_type,
        ]);

        DB::table('banks')->insert([
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
        ]);

        return redirect()->route('loan.create')->with('success', 'Loan application submitted successfully');
    }
}
