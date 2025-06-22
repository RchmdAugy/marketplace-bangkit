<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    /**
     * Menampilkan halaman profil publik sebuah toko/penjual.
     */
    public function show($id)
    {
        // Cari user berdasarkan ID, pastikan dia adalah seorang penjual
        $penjual = User::where('id', $id)->where('role', 'penjual')->firstOrFail();

        // Ambil semua produk dari penjual tersebut yang sudah disetujui (approved)
        $produks = Produk::where('user_id', $penjual->id)
                        ->where('is_approved', true)
                        ->latest()
                        ->get();

        // Kirim data penjual dan produknya ke view
        return view('toko.show', compact('penjual', 'produks'));
    }
}