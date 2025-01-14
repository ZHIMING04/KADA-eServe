<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Auth\MemberController;

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

            // Redirect based on role
            if ($user->isAn('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isA('member')) {
                return redirect()->route('member.dashboard');
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
