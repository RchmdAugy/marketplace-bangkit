<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends AdminBaseController
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahProduk = Produk::count();
        $totalPendapatan = Transaksi::whereIn('status', ['selesai', 'dikirim'])->sum('total_harga');
        $penjualBaru = User::where('role', 'penjual')->where('is_approved', 0)->count();

        $salesData = Transaksi::select(
                DB::raw('SUM(total_harga) as total'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->where('status', 'selesai')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $chartLabels = [];
        $chartData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $label = $month->format('M Y');

            $chartLabels[] = $label;
            $chartData[] = (int) ($salesData[$monthKey]->total ?? 0); // Pastikan data adalah integer
        }

        return view('admin.dashboard', compact(
            'jumlahUser', 
            'jumlahProduk', 
            'totalPendapatan', 
            'penjualBaru',
            'chartLabels',
            'chartData'
        ));
    }
}