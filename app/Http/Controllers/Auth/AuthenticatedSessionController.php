<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Auth\MemberController;
use Illuminate\Support\Facades\DB;
use Bouncer;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();

            // Get the latest member application for this user
            $latestMember = DB::table('member_register')
                ->where('email', $user->email)
                ->orderBy('updated_at', 'desc')
                ->first();

            // Check if email is verified for members
            if ($user->isA('member') && !$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            // Redirect based on latest application status and role
            if ($user->isAn('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isA('member')) {
                if ($latestMember && in_array($latestMember->status, ['approved', 'resigned', 'deceased'])) {
                    return redirect()->route('member.dashboard');
                } else {
                    // If latest application is not in allowed statuses, treat as guest
                    Bouncer::retract('member')->from($user);
                    Bouncer::assign('guest')->to($user);
                    Bouncer::refresh();
                    return redirect()->route('guest.dashboard');
                }
            }

            // Default redirect for guest role
            return redirect()->route('guest.dashboard');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors([
                'email' => 'ID Pengguna atau Kata Laluan tidak sah.',
            ])->withInput($request->only('email'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
