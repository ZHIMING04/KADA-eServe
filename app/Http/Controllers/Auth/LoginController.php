<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;

class LoginController extends Controller
{
    protected $redirectTo = '/dashboard';

    protected function authenticated(Request $request, $user)
    {

        // Refresh Bouncer cache for the user
        Bouncer::refresh();
        
        // Reload user instance with fresh roles
        $user = $user->fresh();
        
        if ($user->isAn('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('guest.dashboard'); // default redirect for non-admin users
      
    }
} 