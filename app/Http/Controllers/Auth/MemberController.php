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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'ic' => ['required', 'string', 'max:14'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'poskod' => ['required', 'string'],
            'DOB' => ['required', 'date'],
            'state' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'gred' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
        ]);

        // Insert data into the 'users' table and get the ID
        $userId = DB::table('users')->insertGetId([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'ic' => $validatedData['ic'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'poskod' => $validatedData['poskod'],
            'DOB' => $validatedData['DOB'],
            'state' => $validatedData['state'],
            'gender' => $validatedData['gender'],
            'gred' => $validatedData['gred'],
            'salary' => $validatedData['salary'],
        ]);

        // Insert login credentials
        DB::table('login_sessions')->insert([
            'user_id' => $userId,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'member',
        ]);

        return redirect()->route('welcome')->with('success', 'Member registered successfully');
    }
}

