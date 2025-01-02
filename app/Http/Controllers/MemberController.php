<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        return view('register-member');
    }

    public function create()
    {
        return view('register-member.create');
    }

    public function store(Request $request)
    {

    // Insert data into the 'registered_members' table
    DB::table('mbaddresses')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'ic' => $request->ic,
        'phone' => $request->phone,
        'address' => $request->address,
        'city' => $request->city,
        'poskod' => $request->poskod,
        'state' => $request->state,
        'gender' => $request->gender,
        'gred'=> $request->gred,
        'salary' => $request->salary,
        
    ]);

    DB::table('employment_details')->insert([
        'member_id' => $member_id,

    ]);

    DB::table('member_details')->insert([

    ]);
    
            // Redirect to the member registration form with a success message      
            return redirect()->route('register-member.create')->with('success', 'Member registered successfully');
            //here redirect to the member registration form with a success message
    }
}