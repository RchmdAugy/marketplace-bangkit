<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard');
    }

    public function dashboard() {
    $user = Auth::user();

    if($user->role == 'admin') {
        $total_produk = Produk::count();
        $total_transaksi = Transaksi::count();
        $total_ulasan = Review::count();

        // Data grafik (total transaksi per bulan)
        $grafik = Transaksi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                    ->groupBy('bulan')->pluck('total', 'bulan');
    } elseif($user->role == 'penjual') {
        $total_produk = Produk::where('user_id', $user->id)->count();
        $total_transaksi = Transaksi::whereHas('details.produk', function($q) use ($user){
                                $q->where('user_id', $user->id);
                            })->count();
        $total_ulasan = Review::whereHas('produk', function($q) use ($user){
                                $q->where('user_id', $user->id);
                            })->count();

        $grafik = Transaksi::whereHas('details.produk', function($q) use ($user){
                        $q->where('user_id', $user->id);
                    })
                    ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                    ->groupBy('bulan')->pluck('total', 'bulan');

        $total_profit = \App\Models\Transaksi::whereHas('details.produk', function($q) use ($user){
                $q->where('user_id', $user->id);
            })
            ->whereIn('status', ['dikirim', 'selesai'])
            ->with('details.produk')
            ->get()
            ->reduce(function($carry, $trx) use ($user) {
                foreach($trx->details as $detail) {
                    if($detail->produk && $detail->produk->user_id == $user->id) {
                        $carry += $detail->harga * $detail->jumlah;
                    }
                }
                return $carry;
            }, 0);

        return view('dashboard.statistik', compact(
            'total_produk', 'total_transaksi', 'total_ulasan', 'grafik', 'total_profit'
        ));

    } else {
        return redirect()->route('home')->withErrors('Akses dashboard hanya untuk Admin / Penjual.');
    }

    return view('dashboard.statistik', compact('total_produk', 'total_transaksi', 'total_ulasan', 'grafik'));
}

    public function statistik()
    {
        $total_produk = Produk::count();
        $total_transaksi = Transaksi::count();
        $total_ulasan = \App\Models\Review::count();
        $total_profit = Transaksi::where('status', 'selesai')->sum('total_harga');

        // Data untuk grafik transaksi per bulan
        $grafik = Transaksi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Data untuk pie chart status transaksi
        $status_transaksi = Transaksi::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Pastikan semua status ada dalam data
        $status_labels = ['menunggu pembayaran', 'diproses', 'dikirim', 'selesai'];
        $status_data = [];
        foreach ($status_labels as $status) {
            $status_data[$status] = $status_transaksi[$status] ?? 0;
        }

        return view('dashboard.statistik', compact(
            'total_produk',
            'total_transaksi',
            'total_ulasan',
            'total_profit',
            'grafik',
            'status_data'
        ));
    }
}
