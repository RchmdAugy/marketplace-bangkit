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

            // <-- DIHAPUS
            // Logika untuk mengecek approval penjual tidak lagi diperlukan
            // saat login, karena tidak ada penjual baru.
            /*
            if ($user->role === 'penjual' && !$user->is_approved) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ]);
            }
            */

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
            } 
            // <-- DIUBAH
            // Logika untuk 'penjual' dan 'pembeli' disatukan.
            // Semua user non-admin akan diarahkan ke 'home'.
            else {
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
        // Aturan validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            // 'role' => 'required|in:pembeli,penjual', // <-- DIHAPUS
        ];

        // <-- DIHAPUS
        // Seluruh blok validasi kondisional untuk penjual dihapus
        /*
        if ($request->role == 'penjual') {
            $rules['nomor_lisensi'] = 'required|string|max:255';
            $rules['file_lisensi'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }
        */

        $request->validate($rules);

        // Siapkan data untuk dimasukkan ke database
        $dataToCreate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembeli', // <-- DIUBAH (Hardcoded menjadi 'pembeli')
            'is_approved' => 1, // <-- DIUBAH (Langsung disetujui)
        ];
        
        // <-- DIHAPUS
        // Seluruh blok untuk upload file lisensi penjual dihapus
        /*
        if ($request->role == 'penjual') {
            if ($request->hasFile('file_lisensi')) {
                $file = $request->file('file_lisensi');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('lisensi_penjual', $filename, 'public'); 
                
                $dataToCreate['nomor_lisensi'] = $request->nomor_lisensi;
                $dataToCreate['file_lisensi'] = $filename;
            }
        }
        */

        // Buat user baru
        User::create($dataToCreate);

        // <-- DIUBAH
        // Pesan sukses disederhanakan, hanya untuk 'pembeli'
        return redirect()->route('login')->with(
            'success', 
            'Registrasi berhasil. Silakan login.'
        );
    }



    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
