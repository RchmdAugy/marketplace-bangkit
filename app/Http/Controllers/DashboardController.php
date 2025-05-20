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
        $total_transaksi = Transaksi::whereHas('produk', function($q) use ($user){
                                $q->where('user_id', $user->id);
                            })->count();
        $total_ulasan = Review::whereHas('produk', function($q) use ($user){
                                $q->where('user_id', $user->id);
                            })->count();

        $grafik = Transaksi::whereHas('produk', function($q) use ($user){
                        $q->where('user_id', $user->id);
                    })
                    ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                    ->groupBy('bulan')->pluck('total', 'bulan');
    } else {
        return redirect()->route('home')->withErrors('Akses dashboard hanya untuk Admin / Penjual.');
    }

    return view('dashboard.statistik', compact('total_produk', 'total_transaksi', 'total_ulasan', 'grafik'));
}
}
