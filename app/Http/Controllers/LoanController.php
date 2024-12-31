<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        return view('loan');
    }

    public function create()
    {
        return view('loan.create');
    }

    public function store(Request $request)
    {

    // Insert data into the 'registered_members' table
    $user_id = DB::table('loan_applicant')->insertGetId([
        'name' => $request->name,
        'ic' => $request->ic,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'agama' => $request->agama,
        'bangsa' => $request->bangsa,
    ]);

    DB::table('addresses')->insert([
        'user_id' => $user_id,
        'address' => $request->address,
        'city' => $request->city,
        'postcode' => $request->postcode,
        'state' => $request->state,
    ]);

    DB::table('offices')->insert([
        'user_id' => $user_id,
        'office_address' => $request->office_address,
        'office_city' => $request->office_city,
        'office_postcode' => $request->office_postcode,
    ]);

    DB::table('banks')->insert([    
        'user_id' => $user_id,
        'bank' => $request->bank,
        'bank_no' => $request->bank_no,
    ]);

    DB::table('financings')->insert([
        'user_id' => $user_id,
        'jenis_pembiayaan' => $request->jenis_pembiayaan,
        'amaun_dipohon' => $request->amaun_dipohon,
        'tempoh_pembiayaan' => $request->tempoh_pembiayaan,
        'ansuran_bulanan' => $request->ansuran_bulanan,
        'bank_id' => $request->bank_id,
    ]);
        
     
    return redirect()->route('loan.create')->with('success', 'Loan Application submitted successfully');
    }

    
}
