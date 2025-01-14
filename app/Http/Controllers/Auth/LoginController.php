<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/dashboard';

    protected function authenticated(Request $request, $user)
    {
        if ($user->isAn('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('guest.dashboard'); // default redirect for non-admin users
      
    }
} 