<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        $rateKey = $this->loginRateKey($request);

        // Lock out after 5 failed attempts within 15 minutes
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $seconds = RateLimiter::availableIn($rateKey);
            $minutes = (int) ceil($seconds / 60);

            Log::warning('Admin login lockout triggered', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'unlock_in_seconds' => $seconds,
            ]);

            return back()
                ->withInput($request->only('email'))
                ->with('lockout', "Too many login attempts. Please try again in {$minutes} minute" . ($minutes === 1 ? '' : 's') . '.');
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($rateKey);
            $request->session()->regenerate();

            Log::info('Admin login success', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
            ]);

            return redirect()->intended(route('admin.dashboard'));
        }

        // Failed attempt - record for rate limiter (15 minute decay)
        RateLimiter::hit($rateKey, 900);

        Log::warning('Admin login failed', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
            'attempts_remaining' => RateLimiter::remaining($rateKey, 5),
        ]);

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Invalid credentials.',
            ]);
    }

    public function logout(Request $request)
    {
        Log::info('Admin logout', [
            'email' => Auth::user()?->email,
            'ip' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function loginRateKey(Request $request): string
    {
        return 'login:' . Str::lower((string) $request->input('email')) . '|' . $request->ip();
    }
}
