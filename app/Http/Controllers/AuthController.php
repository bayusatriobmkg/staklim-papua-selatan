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
        $highlightPassword = $errorKey === 'password';

        return view('auth.login', [
            'loginAlert' => self::ALERTS[$errorKey] ?? null,
            'emailValue' => old('email', $request->query('email', 'staklim.merauke@gmail.com')),
            'emailClass' => 'form-input'.(in_array($errorKey, ['password', 'akun'], true) ? ' is-invalid' : ''),
            'passwordClass' => 'form-input'.($highlightPassword ? ' is-invalid' : ''),
            'emailAutofocus' => ! $highlightPassword,
            'passwordAutofocus' => $highlightPassword,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $error = User::where('email', $credentials['email'])->exists()
                ? 'password'
                : 'akun';

            return redirect('/login?'.http_build_query([
                'error' => $error,
                'email' => $credentials['email'],
            ]));
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
