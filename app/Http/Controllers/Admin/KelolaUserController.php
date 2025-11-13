<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Pastikan ini adalah base controller Anda yang benar
use App\Http\Controllers\Controller; 

class KelolaUserController extends Controller
{
    public function index()
    {
        // FUNGSI INI SUDAH OTOMATIS HANYA MENGAMBIL USER AKTIF (karena SoftDeletes)
        $users = User::orderBy('role')->orderBy('nama')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'role' => 'required|in:admin,pembeli', 
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => 1, 
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:5',
            'role' => 'required|in:admin,penjual,pembeli', 
        ]);

        $userData = $request->only('nama', 'email', 'role');
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        
        if ($user->role !== $request->role) {
             $userData['is_approved'] = $request->role === 'penjual' ? 0 : 1;
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors('Anda tidak bisa menghapus akun sendiri.');
        }

        // INI SEKARANG OTOMATIS MENJADI SOFT DELETE
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dinonaktifkan.'); // Ubah pesan
    }


    // --- FUNGSI BARU UNTUK FITUR SAMPAH/RESTORE ---

    /**
     * Menampilkan daftar user yang sudah di-soft-delete (di keranjang sampah).
     */
    public function sampah()
    {
        // Ambil HANYA user yang sudah di-soft-delete
        $users = User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        
        // Kirim ke view baru 'admin.users.sampah'
        return view('admin.users.sampah', compact('users'));
    }

    /**
     * Memulihkan user yang sudah di-soft-delete.
     */
    public function restore($id)
    {
        // Cari user di keranjang sampah berdasarkan ID
        $user = User::onlyTrashed()->findOrFail($id);
        
        // Perintah untuk memulihkan user
        $user->restore(); 

        return redirect()->route('admin.users.sampah')->with('success', 'User berhasil dipulihkan.');
    }

    /**
     * Menghapus user secara permanen dari database.
     */
    public function forceDelete($id)
    {
        // Cari user di keranjang sampah berdasarkan ID
        $user = User::onlyTrashed()->findOrFail($id);
        
        // Perintah untuk menghapus permanen
        $user->forceDelete(); 

        return redirect()->route('admin.users.sampah')->with('success', 'User berhasil dihapus permanen.');
    }
}