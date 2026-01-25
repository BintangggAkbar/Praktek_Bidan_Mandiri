<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Cek apakah user dengan email/username tersebut ada
        $user = \App\Models\User::where($fieldType, $login)->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Username atau email tidak ditemukan.',
            ])->onlyInput('login');
        }

        $credentials = [
            $fieldType => $login,
            'password' => $request->input('password')
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'description' => 'User logged in',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Check Status for Bidan
            if ($user->role === 'bidan' && $user->status === 'nonaktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'login' => 'Akun bidan Anda sedang nonaktif. Silakan hubungi admin.',
                ])->onlyInput('login');
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        // Jika sampai sini, berarti password salah
        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'description' => 'User logged out',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
