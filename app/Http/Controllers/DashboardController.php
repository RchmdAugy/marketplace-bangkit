<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Review;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function statistik()
    {
        $user = Auth::user();
        $grafikData = collect();
        $status_transaksi = collect();
        $total_profit = 0; // Inisialisasi

        if ($user->role == 'admin') {
            $total_produk = Produk::count();
            $total_transaksi = Transaksi::whereIn('status', ['diproses', 'dikirim', 'selesai'])->count();
            $total_ulasan = Review::count();
            $total_profit = Transaksi::whereIn('status', ['selesai', 'dikirim'])->sum('total_harga');

            $grafikData = Transaksi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->whereIn('status', ['diproses', 'dikirim', 'selesai'])
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->pluck('total', 'bulan');

            $status_transaksi = Transaksi::selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

        } elseif ($user->role == 'penjual') {
            $total_produk = Produk::where('user_id', $user->id)->count();

            $total_transaksi = Transaksi::whereHas('details.produk', function($q) use ($user){
                    $q->where('user_id', $user->id);
                })
                ->whereIn('status', ['diproses', 'dikirim', 'selesai'])
                ->count();

            $total_ulasan = Review::whereHas('produk', function($q) use ($user){
                    $q->where('user_id', $user->id);
                })->count();

            $total_profit = TransaksiDetail::whereHas('produk', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->whereHas('transaksi', function ($q) {
                    $q->whereIn('status', ['selesai', 'dikirim']);
                })
                ->sum(DB::raw('jumlah * harga'));

            $grafikData = Transaksi::whereHas('details.produk', function($q) use ($user){
                    $q->where('user_id', $user->id);
                })
                ->whereYear('created_at', date('Y'))
                ->whereIn('status', ['diproses', 'dikirim', 'selesai'])
                ->selectRaw('MONTH(created_at) as bulan, COUNT(DISTINCT transaksis.id) as total')
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->pluck('total', 'bulan');

             $status_transaksi = Transaksi::whereHas('details.produk', function($q) use ($user){
                    $q->where('user_id', $user->id);
                })
                ->selectRaw('status, COUNT(DISTINCT transaksis.id) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

        } else {
            return redirect()->route('home')->withErrors('Akses dashboard ditolak.');
        }

        $grafik = collect(range(1, 12))->mapWithKeys(function ($bulan) use ($grafikData) {
            $namaBulan = Carbon::create()->month($bulan)->format('M'); // Ubah ke nama bulan singkat (Jan, Feb,...)
            return [$namaBulan => $grafikData->get($bulan, 0)];
        });

        // ===============================================
        // ==  PERUBAHAN STATUS ADA DI SINI            ==
        // ===============================================
        // Hanya ambil 4 status utama
        $status_labels = ['menunggu pembayaran', 'diproses', 'dikirim', 'selesai'];
        $status_data = [];
        foreach ($status_labels as $status) {
            // Ambil data dari $status_transaksi jika ada, jika tidak 0
            $status_data[$status] = $status_transaksi->get($status, 0);
        }
        // ===============================================
        // ==  AKHIR PERUBAHAN STATUS                  ==
        // ===============================================


        return view('dashboard.statistik', compact(
            'total_produk',
            'total_transaksi',
            'total_ulasan',
            'total_profit',
            'grafik',
            'status_data' // Kirim data 4 status saja
        ));
    }
}