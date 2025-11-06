<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Pastikan base controller benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfilController extends Controller
{
    /**
     * Menampilkan halaman profil admin.
     */
    public function show()
    {
        $admin = Auth::user(); // Ambil data admin yang sedang login

        // Pastikan hanya admin yang bisa akses
        if ($admin->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin.profil.show', compact('admin'));
    }

    // Anda bisa tambahkan method edit() dan update() di sini nanti
    // public function edit() { ... }
    // public function update(Request $request) { ... }
}
