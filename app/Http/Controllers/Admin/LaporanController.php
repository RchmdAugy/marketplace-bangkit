<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LaporanController extends AdminBaseController
{
    public function penjualan()
    {
        // Ambil ID semua penjual
        $sellerIds = User::where('role', 'penjual')->pluck('id');

        // Query transaksi yang produknya dimiliki oleh penjual
        $laporan = Transaksi::select(
                'produks.user_id',
                'users.nama as nama_penjual',
                DB::raw('COUNT(transaksis.id) as jumlah_transaksi'),
                DB::raw('SUM(transaksis.total_harga) as total_pendapatan')
            )
            ->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.transaksi_id')
            ->join('produks', 'transaksi_details.produk_id', '=', 'produks.id')
            ->join('users', 'produks.user_id', '=', 'users.id')
            ->whereIn('transaksis.status', ['selesai', 'dikirim'])
            ->whereIn('produks.user_id', $sellerIds)
            ->groupBy('produks.user_id', 'users.nama')
            ->orderBy('total_pendapatan', 'desc')
            ->get();

        return view('admin.laporan.penjualan', compact('laporan'));
    }
}