<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;


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
            $pesanans = Transaksi::whereHas('produk', function($q){
                $q->where('user_id', Auth::id());
            })->with(['produk', 'user'])->get();
        } 
        else {
            return redirect()->route('home')->withErrors('Akses ditolak.');
        }
    
        return view('transaksi.pesanan', compact('pesanans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Validasi akses: hanya admin/seller produk ini yg boleh update
        if(Auth::user()->role == 'admin' || (Auth::user()->role == 'penjual' && $transaksi->produk->user_id == Auth::id())) {
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
    $transaksi = Transaksi::with(['produk', 'user'])->findOrFail($id);

    // Validasi akses + status pesanan sudah layak invoice
    if(
        in_array($transaksi->status, ['dikirim', 'selesai']) &&
        ( Auth::user()->role == 'admin' ||
          Auth::id() == $transaksi->user_id ||
          (Auth::user()->role == 'penjual' && $transaksi->produk->user_id == Auth::id())
        )
    ) {
        $pdf = Pdf::loadView('transaksi.invoice', compact('transaksi'));
        return $pdf->download('invoice_pesanan_'.$transaksi->id.'.pdf');
    } else {
        return back()->withErrors('Invoice hanya bisa dicetak jika pesanan sudah dikirim/selesai.');
    }
}



}
