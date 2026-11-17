<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login admin.
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect('/admin');
        }

        $errorKey = $request->query('error');
        $loginAlerts = [
            'password' => [
                'title' => 'Kata sandi salah',
                'text' => 'Email ditemukan, tetapi kata sandi yang dimasukkan tidak sesuai. Silakan coba lagi.',
            ],
            'akun' => [
                'title' => 'Akun tidak ditemukan',
                'text' => 'Email tersebut belum terdaftar sebagai pengelola.',
            ],
            'session' => [
                'title' => 'Sesi berakhir',
                'text' => 'Anda belum masuk atau sesi login hilang. Masukkan email dan kata sandi lagi.',
            ],
        ];

        return view('auth.login', [
            'loginAlert' => $loginAlerts[$errorKey] ?? null,
            'loginEmail' => old('email', $request->query('email', 'staklim.merauke@gmail.com')),
            'highlightPassword' => $errorKey === 'password',
            'highlightEmail' => in_array($errorKey, ['password', 'akun'], true),
        ]);
    }

    /**
     * Proses otentikasi login admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect('/admin')->with('status', 'Selamat datang kembali di Panel Pengelola Data.');
        }

        $error = User::where('email', $credentials['email'])->exists()
            ? 'password'
            : 'akun';

        return redirect('/login?error='.$error.'&email='.urlencode($credentials['email']))
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $error === 'password'
                    ? 'Kata sandi yang Anda masukkan salah.'
                    : 'Akun dengan email tersebut tidak ditemukan.',
            ]);
    }

    /**
     * Proses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah berhasil keluar dari sesi admin.');
    }
}
