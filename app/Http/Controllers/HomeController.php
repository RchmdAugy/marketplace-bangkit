<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan ini di-import
use App\Models\Slider; // Pastikan ini di-import
use App\Models\TransaksiDetail; // Import ini
use Illuminate\Support\Facades\DB; // Import ini

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();

        // --- LOGIKA BARU UNTUK PRODUK UNGGULAN ---
        $jumlahProdukUnggulan = 8;

        // 1. Ambil ID Produk Terlaris (berdasarkan jumlah terjual)
        $produkTerlarisIds = TransaksiDetail::select('produk_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            // Filter hanya transaksi yang relevan
            ->whereIn('transaksis.status', ['diproses', 'dikirim', 'selesai'])
            // Pastikan produknya masih ada dan disetujui
            ->whereHas('produk', function ($q) {
                $q->where('is_approved', true);
            })
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->limit($jumlahProdukUnggulan)
            ->pluck('produk_id'); // Ambil ID produknya saja

        // 2. Ambil data produk terlaris (dengan relasi user & category)
        // Bangun query-nya terlebih dahulu
        $produksUnggulanQuery = Produk::with(['user', 'category', 'images']) // Eager load relasi
                                    ->whereIn('id', $produkTerlarisIds)
                                    ->where('is_approved', true); // Double check approval

        // --- AWAL PERBAIKAN ---
        // Hanya terapkan pengurutan FIELD jika collection $produkTerlarisIds TIDAK kosong
        if ($produkTerlarisIds->isNotEmpty()) {
            $produksUnggulanQuery->orderByRaw(DB::raw("FIELD(id, " . implode(',', $produkTerlarisIds->toArray()) . ")"));
        }
        // --- AKHIR PERBAIKAN ---

        // Eksekusi query untuk mendapatkan collection
        $produksUnggulan = $produksUnggulanQuery->get();


        // 3. Jika kurang dari $jumlahProdukUnggulan, tambahkan produk lain secara acak
        $jumlahKurang = $jumlahProdukUnggulan - $produksUnggulan->count();
        if ($jumlahKurang > 0) {
            $produkTambahan = Produk::with(['user', 'category', 'images'])
                                    ->where('is_approved', true)
                                    // Kecualikan produk yang sudah masuk list terlaris
                                    ->whereNotIn('id', $produkTerlarisIds)
                                    ->inRandomOrder() // Ambil acak
                                    ->limit($jumlahKurang)
                                    ->get();

            // Gabungkan produk terlaris dengan produk tambahan
            $produksUnggulan = $produksUnggulan->concat($produkTambahan);
        }
        // --- AKHIR LOGIKA BARU ---

        // Kirim $produksUnggulan ke view (ganti nama variabel jika perlu)
        return view('landing', compact('sliders', 'produksUnggulan'));
    }
}