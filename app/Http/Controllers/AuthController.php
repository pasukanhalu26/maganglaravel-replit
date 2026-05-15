<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) { return redirect()->intended('dashboard'); }
        return view('auth.login');
    }

    public function login(Request $request) {
                $request->validate([
            'kode_id' => 'required|string',
            'password' => 'required'
        ], [
            'kode_id.required' => 'Kode ID wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Deteksi apakah yang diinput adalah email atau Kode ID
        $loginField = filter_var($request->kode_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => ($loginField == 'username') ? strtoupper($request->kode_id) : $request->kode_id,
            'password'  => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Cek status user
            if (Auth::user()->status != 1) {
                Auth::logout();
                return back()->withErrors(['kode_id' => 'Akun Anda tidak aktif. Hubungi Administrator.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()
            ->withErrors(['kode_id' => 'Kode ID atau Password salah!'])
            ->withInput($request->only('kode_id'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}