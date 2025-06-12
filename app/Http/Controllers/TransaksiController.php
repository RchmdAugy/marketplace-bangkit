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
use App\Models\TransaksiDetail;

class TransaksiController extends Controller
{
    public function index() {
        // Pembeli lihat transaksi mereka
        $transaksis = Transaksi::with('produk')->where('user_id', Auth::id())->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function show($id) {
        $transaksi = Transaksi::with('details.produk', 'user')->findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
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
            'alamat' => 'required|string',
        ]);

        $total = $produk->harga * $request->jumlah;

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total,
            'status' => 'menunggu pembayaran',
            'alamat_pengiriman' => $request->alamat,
        ]);

        // Buat Snap Token Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $payload = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $transaksi->id . '-' . time(),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $produk->id,
                    'price' => $produk->harga,
                    'quantity' => $request->jumlah,
                    'name' => $produk->nama
                ]
            ],
            'finish_redirect_url' => route('transaksi.index'),
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $transaksi->snap_token = $snapToken;
            $transaksi->save();
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: ' . $e->getMessage());
        }

        return redirect()->route('transaksi.pembayaran', $transaksi->id);
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

    $request->validate([
        'alamat' => 'required|string',
    ]);

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

        $total_bayar = $total; // Tidak ada ongkir

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'total_harga' => $total_bayar,
            'status' => 'menunggu pembayaran',
            'alamat_pengiriman' => $request->alamat,
            // 'ongkir' => 0, // Tidak perlu lagi
        ]);

        // Buat detail transaksi untuk setiap item di keranjang
        foreach ($keranjangs as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'harga' => $item->produk->harga, // Harga saat transaksi dilakukan
            ]);
            // Kurangi stok produk
            $item->produk->decrement('stok', $item->jumlah);
        }

        // Hapus item dari keranjang setelah checkout
        Keranjang::where('user_id', $user->id)->delete();

        // Buat Snap Token Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $payload = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $transaksi->id . '-' . time(),
                'gross_amount' => $total_bayar,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => $keranjangs->map(function($item) {
                return [
                    'id' => $item->produk_id,
                    'price' => $item->produk->harga,
                    'quantity' => $item->jumlah,
                    'name' => $item->produk->nama
                ];
            })->toArray(),
            'finish_redirect_url' => route('transaksi.index'),
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $transaksi->snap_token = $snapToken;
            $transaksi->save();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return redirect()->route('keranjang.index')->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }

        DB::commit();
        return redirect()->route('transaksi.pembayaran', $transaksi->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout Keranjang Error: ' . $e->getMessage());
        return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
    }
}

public function showPembayaran($id)
{
    $transaksi = Transaksi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    return view('transaksi.pembayaran', compact('transaksi'));
}

public function konfirmasiPembayaran(Request $request, $id)
{
    \Log::info('konfirmasiPembayaran dipanggil untuk transaksi ID: ' . $id);
    \Log::info('Request headers: ' . json_encode($request->headers->all()));
    \Log::info('Request full data: ' . json_encode($request->all()));

    $transaksi = Transaksi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $jsonCallback = json_decode($request->json, true);
    \Log::info('Midtrans JSON Callback after decode: ' . json_encode($jsonCallback));

    // Cek apakah ada data callback dari Midtrans
    if (empty($jsonCallback) || !isset($jsonCallback['transaction_status'])) {
        \Log::warning('Midtrans JSON Callback tidak lengkap atau kosong untuk transaksi ID: ' . $id);
        // Jika callback tidak lengkap, pertahankan status sebelumnya atau set ke pending jika transaksi masih baru
        if ($transaksi->status == 'menunggu pembayaran') {
            $transaksi->status = 'pending';
        }
    } else {
        $transactionStatus = $jsonCallback['transaction_status'];
        $fraudStatus = $jsonCallback['fraud_status'] ?? null;

        if ($transactionStatus == 'capture') {
            // Untuk kartu kredit berstatus capture
            if ($fraudStatus == 'challenge') {
                $transaksi->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $transaksi->status = 'diproses';
            }
        } else if ($transactionStatus == 'settlement') {
            // Pembayaran berhasil (misal: VA, Qris, Gopay, dll)
            $transaksi->status = 'diproses';
        } else if (
            $transactionStatus == 'cancel' ||
            $transactionStatus == 'expire' ||
            $transactionStatus == 'deny'
        ) {
            // Pembayaran dibatalkan/kadaluarsa/ditolak
            $transaksi->status = 'dibatalkan';
        } else if ($transactionStatus == 'pending') {
            // Pembayaran masih menunggu
            $transaksi->status = 'menunggu pembayaran';
        } else {
            // Status Midtrans tidak dikenali
            \Log::warning('Midtrans transaction_status tidak dikenali: ' . $transactionStatus . ' untuk transaksi ID: ' . $id);
            // Pertahankan status sebelumnya atau set ke pending
            if ($transaksi->status == 'menunggu pembayaran') {
                $transaksi->status = 'pending';
            }
        }
    }

    $transaksi->save();
    
    // Logging status akhir
    \Log::info('Status transaksi diperbarui menjadi: ' . $transaksi->status . ' untuk transaksi ID: ' . $id);

    // Redirect ke halaman transaksi.index setelah update status
    return redirect()->route('transaksi.index')->with('success', 'Status pembayaran berhasil diperbarui.');
}


}
