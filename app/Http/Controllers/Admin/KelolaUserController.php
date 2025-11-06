<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Pastikan ini adalah base controller Anda yang benar
use App\Http\Controllers\Controller; 

// class KelolaUserController extends AdminBaseController
class KelolaUserController extends Controller
{
    public function index()
    {
        // DIKEMBALIKAN: Menampilkan semua user termasuk penjual
        $users = User::orderBy('role')->orderBy('nama')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // VALIDASI TETAP: Hanya bisa membuat Admin atau Pembeli
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'role' => 'required|in:admin,pembeli', // 'penjual' sengaja tidak ada
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => 1, // Otomatis approve karena bukan penjual
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // DIKEMBALIKAN: Mengizinkan edit semua role
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // DIKEMBALIKAN: Validasi mengizinkan 'penjual' (untuk user yang sudah ada)
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
        
        // Menambahkan kembali logika approval jika rolenya diubah
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

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}

