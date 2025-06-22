<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profil.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

    /**
     * Memproses pembaruan data profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi semua input yang mungkin diterima dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nama_toko' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat_toko' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
            'password' => 'nullable|string|min:5|confirmed',
        ]);

        // Menyiapkan data yang akan diupdate
        $dataToUpdate = $request->only('nama', 'email', 'no_telepon');

        // Logika untuk upload foto profil jika ada file yang diunggah
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada untuk menghemat storage
            if ($user->foto_profil && File::exists(public_path('foto_profil/' . $user->foto_profil))) {
                File::delete(public_path('foto_profil/' . $user->foto_profil));
            }
            
            // Simpan foto baru dengan nama unik
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_profil'), $filename); // Simpan ke public/foto_profil
            $dataToUpdate['foto_profil'] = $filename;
        }

        // Jika user adalah penjual, tambahkan data toko ke array update
        if ($user->role == 'penjual') {
            $dataToUpdate['nama_toko'] = $request->nama_toko;
            $dataToUpdate['alamat_toko'] = $request->alamat_toko;
        }

        // Jika password diisi, hash dan tambahkan ke array update
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // Lakukan update ke database
        $user->update($dataToUpdate);

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui.');
    }
}