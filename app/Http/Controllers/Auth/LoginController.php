<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAn('admin')) {
            return redirect('/admin/dashboard');
        }
        
        return redirect('/dashboard'); // default redirect for non-admin users
    }
} 