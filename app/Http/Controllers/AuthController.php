<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login admin.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $isHttps = request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https' || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
            return redirect()->to('/admin', 302, [], $isHttps ? true : null);
        }

        return view('auth.login');
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

            $isHttps = $request->isSecure() || $request->header('X-Forwarded-Proto') === 'https' || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');

            return redirect()->to('/admin', 302, [], $isHttps ? true : null)->with('status', 'Selamat datang kembali di Panel Pengelola Data.');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'Email atau kata sandi yang dimasukkan tidak sesuai.',
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
