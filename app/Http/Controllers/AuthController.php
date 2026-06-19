<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tamu;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Form login gabungan admin & tamu
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login gabungan
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // =========================
        // LOGIN ADMIN
        // =========================
        $admin = Admin::where('username', $request->login)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            Auth::guard('admin')->login($admin);

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        // =========================
        // LOGIN TAMU
        // =========================
        if (
            Auth::guard('tamu')->attempt([
                'email' => $request->login,
                'password' => $request->password
            ])
        ) {

            $request->session()->regenerate();

            return redirect()->route('tamu.dashboard');
        }

        return back()->withErrors([
            'login' => 'Username/email atau password salah.'
        ]);
    }

    // =========================
    // REGISTER KHUSUS TAMU
    // =========================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:tamu,email',
            'password' => 'required|min:6|confirmed',
            'instansi' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $tamu = Tamu::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'instansi' => $request->instansi,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        Auth::guard('tamu')->login($tamu);

        return redirect()->route('tamu.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('tamu')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}