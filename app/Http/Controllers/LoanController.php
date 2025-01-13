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
     /*   $no_anggota = DB::table('member_register')
            ->select('no_anggota')
            ->first();

        $name = DB::table('member_register')
            ->select('name')
            ->first();

        $ic = DB::table('member_register')
            ->select('ic')
            ->first();

        $salary = DB::table('member_register')
            ->select('salary')
            ->first();

        $ic = DB::table('member_register')
            ->select('ic')
            ->first();
       
        $phone = DB::table('member_register')
            ->select('phone')
            ->first();

        $address = DB::table('member_register')
            ->select('address')
            ->first();

        $city = DB::table('member_register')
            ->select('city')
            ->first();

        $postcode = DB::table('member_register')
            ->select('postcode')
            ->first();

        $state = DB::table('member_register')
            ->select('state')
            ->first();

        $gender = DB::table('member_register')
            ->select('gender')
            ->first();
       
        $dob = DB::table('member_register')
            ->select('DOB')
            ->first();

        $agama = DB::table('member_register')
            ->select('agama')
            ->first();

        $bangsa = DB::table('member_register')
            ->select('bangsa')
            ->first();

        $no_pf = DB::table('member_register')
            ->select('no_pf')
            ->first();

        $office_address = DB::table('member_register')
            ->select('office_address')
            ->first();

        $office_city = DB::table('member_register')
            ->select('office_city')
            ->first();

        $office_postcode = DB::table('member_register')
            ->select('office_postcode')
            ->first();

        $office_state = DB::table('member_register')
            ->select('office_state')
            ->first();   

        return view('loan.create', compact('name', 'ic', 'salary', 'phone', 'address', 
        'city', 'postcode', 'state', 'gender', 'dob', 'agama', 'bangsa', 'no_pf',
         'office_address', 'office_city', 'office_postcode', 'office_state'));    */
         return view('loan.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // ... your other validations ...
            'penjamin.*.no_pf' => 'required|string',
            'penjamin.*.name' => 'required|string',
            'penjamin.*.ic' => 'required|string',
            'penjamin.*.phone' => 'required|string'
        ]);

        DB::table('loans')->insert([
            'no_anggota' => $request->no_anggota,
            'name' => $request->name,
            'ic' => $request->ic,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'agama' => $request->agama,
            'bangsa' => $request->bangsa,
            'no_pf' => $request->no_pf,
            'salary' => $request->salary,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'state' => $request->state,
            'office_address' => $request->office_address,
            'office_city' => $request->office_city,
            'office_postcode' => $request->office_postcode,
            'office_state' => $request->office_state,
            'loan_id' => $request->loan_id,
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



