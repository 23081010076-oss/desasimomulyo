<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // ─── Log percobaan login gagal ─────────────────────────────────
            Log::warning('[SECURITY] Login failed', [
                'email' => $request->input('email'),
                'ip'    => $request->ip(),
                'agent' => $request->userAgent(),
            ]);

            // Pesan umum — tidak membocorkan apakah email terdaftar atau tidak
            return back()->withErrors([
                'email' => 'Kredensial yang Anda masukkan tidak valid.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // ─── Log login berhasil ────────────────────────────────────────────
        Log::info('[SECURITY] Login successful', [
            'user_id' => Auth::id(),
            'email'   => Auth::user()->email,
            'ip'      => $request->ip(),
        ]);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'citizen',
        ]);

        Log::info('[SECURITY] New user registered', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'ip'      => $request->ip(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Log::info('[SECURITY] User logged out', [
            'user_id' => Auth::id(),
            'ip'      => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
