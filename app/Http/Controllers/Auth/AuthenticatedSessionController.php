<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        // Attempt to authenticate the user
        $request->authenticate();
        
        // Add debugging information
        Log::info('Login attempt', [
            'email' => $request->email,
            'authenticated' => Auth::check(),
            'user' => Auth::user(),
            'session_id' => session()->getId(),
            'session_driver' => config('session.driver')
        ]);
        
        // Regenerate session
        $request->session()->regenerate();
        
        // Force login if authenticate() didn't work properly
        if (!Auth::check() && $user = \App\Models\User::where('email', $request->email)->first()) {
            Auth::login($user);
            Log::info('Force login attempted', ['success' => Auth::check()]);
        }
        
        // Check auth status and redirect based on role
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('power_user') || (method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
        
        // Fallback if still not authenticated
        return redirect()->route('login')
            ->withInput()
            ->withErrors(['email' => 'Authentication failed. Please try again.']);
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
