<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('home')->with('success', 'Berhasil login!');
        } else {
            return back()->withErrors('Email atau password salah!');
        }
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'role' => 'required',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
