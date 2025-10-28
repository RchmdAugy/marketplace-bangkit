<?php
// File: app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Slider; // <-- BARU: Panggil model Slider
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Bagian ini (Produk) tetap sama
        if (Auth::check() && Auth::user()->role == 'penjual') {
            $produks = Produk::with(['user', 'reviews'])
                             ->where('user_id', Auth::id())
                             ->latest()
                             ->take(8)
                             ->get();
        } else {
            $produks = Produk::with(['user', 'reviews'])
                             ->where('is_approved', true)
                             ->latest()
                             ->take(8)
                             ->get();
        }
        
        // <-- BARU: Ambil data slider yang aktif dari database
        $sliders = Slider::where('is_active', true)
                         ->orderBy('order', 'asc') // Urutkan berdasarkan kolom 'order'
                         ->get();
        
        // <-- DIUBAH: Kirim variabel $sliders ke view
        // (Nama view Anda adalah 'landing', bukan 'home')
        return view('landing', compact('produks', 'sliders'));
    }
}