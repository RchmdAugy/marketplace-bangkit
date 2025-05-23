<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\UserApproval;


class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

  public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();

        // Cek apakah penjual sudah disetujui
        if ($user->role === 'penjual' && !$user->is_approved) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum disetujui oleh admin.',
            ]);
        }

       if ($user->role === 'admin') {
    return redirect()->route('admin.approval')->with('success', 'Selamat datang, Admin!');
} elseif ($user->role === 'penjual') {
    return redirect()->route('home')->with('success', 'Berhasil login!');
} else {
    return redirect()->route('home')->with('success', 'Berhasil login!');
}

    } else {
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }
}


    public function showRegister() {
        return view('auth.register');
    }

public function register(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:5',
        'role' => 'required',
    ]);

    // Jika role penjual, set is_approved = 0, selain itu 1
    $isApproved = $request->role === 'penjual' ? 0 : 1;

    User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_approved' => $isApproved,
    ]);

    return redirect()->route('login')->with('success', $request->role === 'penjual'
        ? 'Registrasi berhasil. Akun Anda akan ditinjau oleh admin.'
        : 'Registrasi berhasil. Silakan login.'
    );
}



    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
