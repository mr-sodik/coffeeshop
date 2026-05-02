<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ================= LOGIN FORM =================
    public function login()
    {
        return view('auth.login');
    }

    // ================= PROSES LOGIN =================
    public function loginProses(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ================= ROLE REDIRECT =================
            if ($user->role === 'admin') {
                return redirect()->intended('/backend/beranda');
            }

            if ($user->role === 'kasir') {
                return redirect()->intended('/kasir');
            }

            if ($user->role === 'customer') {
                return redirect()->intended('/');
            }

            // fallback aman kalau role tidak dikenali
            Auth::logout();
            return redirect('/login')->with('error', 'Role tidak valid');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // ================= REGISTER FORM =================
    public function register()
    {
        return view('auth.register');
    }

    // ================= PROSES REGISTER =================
    public function registerProses(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer'
        ]);

        return redirect('/login')->with('success', 'Register berhasil, silakan login');
    }

    // ================= LUPA PASSWORD =================
    public function lupaPassword()
    {
        return view('auth.lupa_password');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}