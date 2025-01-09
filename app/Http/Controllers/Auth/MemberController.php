<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;



class MemberController extends Controller
{
    public function index()
    {
        return view('auth/register-member');
    }

    public function create()
    {
        return view('auth/register-member');
    }

    public function store(Request $request)
    {

    // Insert data into the 'registered_members' table
    DB::table('registered_members')->insert([
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
    
            // Redirect to the member registration form with a success message      
            return redirect()->route('register-member.create')->with('success', 'Member registered successfully');
            //here redirect to the member registration form with a success message
    }
}

