<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    private const ALERTS = [
        'password' => [
            'title' => 'Kata sandi salah',
            'text' => 'Email ditemukan, tetapi kata sandi yang dimasukkan tidak sesuai.',
        ],
        'akun' => [
            'title' => 'Akun tidak ditemukan',
            'text' => 'Email tersebut belum terdaftar sebagai pengelola.',
        ],
        'session' => [
            'title' => 'Sesi berakhir',
            'text' => 'Anda belum masuk atau sesi login hilang. Silakan masuk lagi.',
        ],
        'csrf' => [
            'title' => 'Form kedaluwarsa',
            'text' => 'Halaman login sudah kedaluwarsa. Isi kata sandi lalu kirim ulang.',
        ],
    ];

    public function showLoginForm(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/admin');
        }

        $errorKey = (string) $request->query('error', '');
        if (! in_array($errorKey, ['password', 'akun', 'session', 'csrf'], true)) {
            $errorKey = '';
        }

        $loginAlert = session('loginAlert') ?? (self::ALERTS[$errorKey] ?? null);

        $emailValue = old('email', 'staklim.merauke@bmkg.go.id');
        $emailValue = htmlspecialchars((string) $emailValue, ENT_QUOTES, 'UTF-8');

        $hasError = ! empty($loginAlert) || in_array($errorKey, ['password', 'akun'], true);

        return view('auth.login', [
            'loginAlert' => $loginAlert,
            'emailValue' => $emailValue,
            'emailClass' => 'form-input'.($hasError ? ' is-invalid' : ''),
            'passwordClass' => 'form-input'.($hasError ? ' is-invalid' : ''),
            'emailAutofocus' => empty($emailValue),
            'passwordAutofocus' => ! empty($emailValue),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email:rfc,filter', 'max:150'],
            'password' => ['required', 'string', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid sesuai standar RFC.',
            'email.max' => 'Panjang karakter email melebihi batas yang diizinkan.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $cleanEmail = filter_var(strtolower(trim($validated['email'])), FILTER_SANITIZE_EMAIL);
        $credentials = [
            'email' => $cleanEmail,
            'password' => (string) $validated['password'],
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput(['email' => $cleanEmail])
                ->with('loginAlert', [
                    'title' => 'Autentikasi gagal',
                    'text' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
                ]);
        }

        $request->session()->regenerate();

        return redirect('/admin');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
