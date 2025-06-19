<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Menggunakan with() untuk Eager Loading relasi user & reviews
        // Ini adalah cara terbaik untuk mencegah error dan membuat query lebih cepat
        if (Auth::check() && Auth::user()->role == 'penjual') {
            // Penjual melihat produknya sendiri
            $produks = Produk::with(['user', 'reviews'])
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->take(8) // Kita tampilkan 8 produk
                            ->get();
        } else {
            // Pembeli & tamu hanya melihat produk yang SUDAH DISETUJUI
            $produks = Produk::with(['user', 'reviews'])
                            ->where('is_approved', true)
                            ->latest()
                            ->take(8)
                            ->get();
        }
        
        return view('landing', compact('produks'));
    }
}