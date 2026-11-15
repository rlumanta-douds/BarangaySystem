<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        // Authenticate the user credentials
        $request->authenticate();

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        $user = Auth::user();

        // Check user role and redirect to the correct dashboard/portal
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'resident') {
            return redirect()->route('resident.portal');
        }

        // Fallback safety check: if role field is blank or invalid, log them out and show error
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'Your account does not have a valid portal role assigned.',
        ]);
    }

    /**
     * Destroy an authenticated session (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}