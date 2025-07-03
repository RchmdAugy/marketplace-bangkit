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
                // DIUBAH: Mengarahkan ke dashboard admin baru
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
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
        // Aturan validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:pembeli,penjual',
        ];

        // Tambahkan aturan validasi kondisional untuk penjual
        if ($request->role == 'penjual') {
            $rules['nomor_lisensi'] = 'required|string|max:255';
            $rules['file_lisensi'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $request->validate($rules);

        // Siapkan data untuk dimasukkan ke database
        $dataToCreate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => $request->role === 'penjual' ? 0 : 1, // Penjual butuh approval
        ];
        
        // Proses upload file lisensi jika rolenya penjual
        if ($request->role == 'penjual') {
            if ($request->hasFile('file_lisensi')) {
                $file = $request->file('file_lisensi');
                $filename = time() . '_' . $file->getClientOriginalName();
                // Simpan ke disk 'public', di dalam folder 'lisensi_penjual'
                $file->storeAs('lisensi_penjual', $filename, 'public'); // <-- KODE BARU
                
                $dataToCreate['nomor_lisensi'] = $request->nomor_lisensi;
                $dataToCreate['file_lisensi'] = $filename;
            }
        }

        // Buat user baru
        User::create($dataToCreate);

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
