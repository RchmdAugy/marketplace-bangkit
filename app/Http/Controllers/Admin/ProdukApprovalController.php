<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;

class ProdukApprovalController extends AdminBaseController
{
    // Menampilkan daftar produk yang menunggu persetujuan
    public function index()
    {
        $pendingProduks = Produk::with('user')
                                ->where('is_approved', false)
                                ->get();
        
        return view('admin.produk.approval', compact('pendingProduks'));
    }

    // Proses untuk menyetujui produk
    public function approve(Produk $produk)
    {
        $produk->update(['is_approved' => true]);

        return redirect()->route('admin.produk.approval')->with('success', 'Produk berhasil disetujui.');
    }
}