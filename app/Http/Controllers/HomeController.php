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
        if (Auth::check() && Auth::user()->role == 'penjual') {
            // Hanya produk milik penjual yang login
            $produks = Produk::where('user_id', Auth::id())->latest()->take(6)->get();
        } else {
            // Untuk pembeli/tamu, tampilkan semua produk
            $produks = Produk::latest()->take(6)->get();
        }
        return view('landing', compact('produks'));
    }
}
