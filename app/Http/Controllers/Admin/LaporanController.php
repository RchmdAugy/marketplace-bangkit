<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Produk;
use App\Models\TransaksiDetail;
use App\Http\Controllers\Controller; // Pastikan base controller benar

// class LaporanController extends AdminBaseController // Sesuaikan jika perlu
class LaporanController extends Controller
{
    /**
     * Menampilkan laporan total penjualan per penjual.
     */
    public function penjualan()
    {
        $laporan = User::select(
                'users.id as user_id',
                'users.nama as nama_penjual',
                DB::raw('COUNT(DISTINCT transaksis.id) as jumlah_transaksi'),
                DB::raw('SUM(transaksi_details.jumlah * transaksi_details.harga) as total_pendapatan')
            )
            ->join('produks', 'users.id', '=', 'produks.user_id')
            ->join('transaksi_details', 'produks.id', '=', 'transaksi_details.produk_id')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->where('users.role', 'penjual')
            // ===============================================
            // ==  PERUBAHAN STATUS ADA DI SINI            ==
            // ===============================================
            ->whereIn('transaksis.status', ['selesai', 'dikirim', 'diproses']) // Tambahkan 'diproses'
            // ===============================================
            ->groupBy('users.id', 'users.nama')
            ->orderBy('total_pendapatan', 'desc')
            ->get();

        return view('admin.laporan.penjualan', compact('laporan'));
    }

    /**
     * Menampilkan detail laporan penjualan produk per penjual.
     */
    public function detailProduk(User $penjual)
    {
        if ($penjual->role !== 'penjual') {
            abort(404, 'Penjual tidak ditemukan.');
        }

        $laporanProduk = TransaksiDetail::select(
                'produks.id as produk_id',
                'produks.nama as nama_produk',
                'produks.nama_umkm',
                DB::raw('SUM(transaksi_details.jumlah) as total_terjual'),
                DB::raw('SUM(transaksi_details.jumlah * transaksi_details.harga) as total_pendapatan_produk')
            )
            ->join('produks', 'transaksi_details.produk_id', '=', 'produks.id')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->where('produks.user_id', $penjual->id)
            // ===============================================
            // ==  PERUBAHAN STATUS ADA DI SINI            ==
            // ===============================================
            ->whereIn('transaksis.status', ['selesai', 'dikirim', 'diproses']) // Tambahkan 'diproses'
            // ===============================================
            ->groupBy('produks.id', 'produks.nama', 'produks.nama_umkm')
            ->orderBy('total_terjual', 'desc')
            ->get();

        return view('admin.laporan.detail_produk', compact('penjual', 'laporanProduk'));
    }
}