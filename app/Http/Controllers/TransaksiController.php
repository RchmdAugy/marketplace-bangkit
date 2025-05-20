<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index() {
        // Pembeli lihat transaksi mereka
        $transaksis = Transaksi::with('produk')->where('user_id', Auth::id())->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function show($id) {
        $transaksi = Transaksi::findOrFail($id);
        $produk = $transaksi->produk; // ambil relasi produk dari transaksi
    
        return view('transaksi.detail', compact('transaksi', 'produk'));
    }
    

    // Proses checkout
    public function checkout($produk_id) {
        $produk = Produk::findOrFail($produk_id);
        return view('transaksi.checkout', compact('produk'));
    }

    public function prosesCheckout(Request $request, $produk_id) {
        $produk = Produk::findOrFail($produk_id);

        $request->validate([
            'jumlah' => 'required|numeric|min:1|max:' . $produk->stok,
        ]);

        $total = $produk->harga * $request->jumlah;

        Transaksi::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total,
            'status' => 'menunggu pembayaran',
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Pesanan berhasil dibuat. Lakukan pembayaran.');
    }

    public function pesanan() {
        // Kalau admin → lihat semua transaksi
        if(Auth::user()->role == 'admin') {
            $pesanans = Transaksi::with(['produk', 'user'])->get();
        } 
        // Kalau seller → lihat transaksi produk dia saja
        elseif (Auth::user()->role == 'penjual') {
            $pesanans = \App\Models\Transaksi::whereHas('details.produk', function($q) {
                $q->where('user_id', Auth::id());
            })->with('details.produk', 'user')->get();
        } 
        else {
            return redirect()->route('home')->withErrors('Akses ditolak.');
        }
    
        return view('transaksi.pesanan', compact('pesanans'));
    }

public function updateStatus(Request $request, $id)
{
    $transaksi = Transaksi::with('details.produk')->findOrFail($id);

    // Cek apakah penjual punya produk di transaksi ini
    $isSeller = false;
    if (Auth::user()->role == 'penjual') {
        foreach ($transaksi->details as $detail) {
            if ($detail->produk && $detail->produk->user_id == Auth::id()) {
                $isSeller = true;
                break;
            }
        }
    }

    if(Auth::user()->role == 'admin' || $isSeller) {
        $request->validate([
            'status' => 'required|in:menunggu pembayaran,diproses,dikirim,selesai',
        ]);

        $transaksi->status = $request->status;
        $transaksi->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    } else {
        return back()->withErrors('Akses ditolak.');
    }
}

public function cetakInvoice($id)
{
    $transaksi = Transaksi::with(['details.produk', 'user'])->findOrFail($id);

    // Validasi akses + status pesanan sudah layak invoice
    $isSeller = false;
    if (Auth::user()->role == 'penjual') {
        foreach ($transaksi->details as $detail) {
            if ($detail->produk && $detail->produk->user_id == Auth::id()) {
                $isSeller = true;
                break;
            }
        }
    }

    if(
        in_array($transaksi->status, ['dikirim', 'selesai']) &&
        ( Auth::user()->role == 'admin' ||
        Auth::id() == $transaksi->user_id ||
        $isSeller
        )
    ) {
        $pdf = Pdf::loadView('transaksi.invoice', compact('transaksi'));
        return $pdf->download('invoice_pesanan_'.$transaksi->id.'.pdf');
    } else {
        return back()->withErrors('Invoice hanya bisa dicetak jika pesanan sudah dikirim/selesai.');
    }
}

public function checkoutKeranjang(Request $request)
{
    $user = Auth::user();
    $keranjangs = Keranjang::where('user_id', $user->id)->with('produk')->get();

    if ($keranjangs->isEmpty()) {
        return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
    }

    DB::beginTransaction();
    try {
        $total = 0;
        foreach ($keranjangs as $item) {
            if ($item->jumlah > $item->produk->stok) {
                DB::rollBack();
                return redirect()->route('keranjang.index')->with('error', 'Stok produk '.$item->produk->nama.' tidak mencukupi.');
            }
            $total += $item->jumlah * $item->produk->harga;
        }

        // Buat transaksi utama
        $transaksi = \App\Models\Transaksi::create([
            'user_id' => $user->id,
            'total_harga' => $total,
            'status' => 'menunggu pembayaran'
        ]);

        // Buat detail transaksi
        foreach ($keranjangs as $item) {
            $item->produk->decrement('stok', $item->jumlah);
            \App\Models\TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'harga' => $item->produk->harga
            ]);
        }

        Keranjang::where('user_id', $user->id)->delete();
        DB::commit();
        return redirect()->route('transaksi.index')->with('success', 'Checkout berhasil!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat checkout.');
    }
}

}
