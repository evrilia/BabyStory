<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //menampilkan halaman login admin
    public function showLoginForm()
    {
        return view('pages.auth.login-admin');
    }

     
    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login_error' => 'Username atau password salah.']);
    }

    // Dashboard setelah login
    public function dashboard()
    {
        return view('pages.admin.dashboard'); // nanti kamu bisa buat file dashboard-nya
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
   
