<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
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
        // dd($request);
        try {
            // Start with a clean session
            Session::flush();
            
            // Attempt authentication
            $request->authenticate();
            // dd($request->authenticate());

            // Force regenerate session
            $request->session()->regenerate();
            
            $user = Auth::user();
            if (!$user) {
                Log::error('No user after authentication');
                return redirect()->route('login');
            }

            // Set role and session data
            $role = \App\Models\Tpa::where('users_id', $user->id)->exists() ? 'TPA' : 'Dosen';
            $sessionData = array_merge($user->toArray(), ['role' => [$role]]);
            
            // Store in session
            session(['account' => $sessionData]);
            
            // Log the successful login
            Log::info('Login successful', [
                'user_id' => $user->id,
                'session_id' => session()->getId()
            ]);

            // Return to dashboard with session cookie
            return redirect()->intended(route('home'))
                ->withCookie(cookie()->forever('auth_check', true));
                
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Login exception', ['error' => $e->getMessage()]);
            return redirect()->route('login')
                ->withErrors(['email_institusi' => 'Login failed']);
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
