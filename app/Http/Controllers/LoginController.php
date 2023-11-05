<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
{
    // validasi data yang diterima dari form login
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // mencoba untuk melakukan autentikasi
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // jika berhasil, redirect ke halaman dashboard
        return redirect()->intended('dashboard');
    }

    // jika gagal, kembali ke halaman login dengan pesan error
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}
}
