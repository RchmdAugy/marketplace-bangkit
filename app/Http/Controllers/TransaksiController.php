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
use Exception;
use Log;

class TransaksiController extends Controller
{
    public function index() {
        $transaksis = Transaksi::with('details.produk') 
                                ->where('user_id', Auth::id())
                                ->latest() 
                                ->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function show($id) {
        $transaksi = Transaksi::with('details.produk', 'user')->findOrFail($id);
        if(Auth::user()->role == 'pembeli' && $transaksi->user_id != Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        $pesanWhatsapp = null;
        if ($transaksi->status == 'diproses') { 
            $nomorPLUT = config('app.plut_whatsapp_number'); 
            
            if(!$nomorPLUT) {
                Log::warning('Nomor WhatsApp PLUT belum diatur di .env (PLUT_WHATSAPP_NUMBER)');
            } else {
                $pesan = "Halo PLUT,\n\n";
                $pesan .= "Saya ingin mengonfirmasi pesanan saya dengan detail berikut:\n\n";
                $pesan .= "*No. Transaksi:* " . $transaksi->id . "\n";
                $pesan .= "*Tanggal:* " . $transaksi->created_at->format('d M Y, H:i') . "\n";
                $pesan .= "*Pembeli:* " . $transaksi->user->nama . "\n\n";
                $pesan .= "*Alamat Pengiriman:*\n" . $transaksi->alamat_pengiriman . "\n\n";
                $pesan .= "*Detail Pesanan:*\n";
                
                foreach ($transaksi->details as $detail) {
                    $pesan .= "- " . ($detail->produk->nama ?? 'Produk Dihapus') . "\n";
                    $pesan .= "  (" . $detail->jumlah . " x Rp " . number_format($detail->harga, 0, ',', '.') . ")\n";
                }
                
                $pesan .= "\n*Total Bayar:* Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n\n";
                $pesan .= "Mohon segera diproses. Terima kasih.";
                
                // --- INI PERBAIKANNYA ---
                // Mengganti format link dari wa.me ke api.whatsapp.com
                $pesanWhatsapp = 'https://api.whatsapp.com/send?phone=' . $nomorPLUT . '&text=' . urlencode($pesan);
                // --- AKHIR PERBAIKAN ---
            }
        }

        return view('transaksi.detail', compact('transaksi', 'pesanWhatsapp'));
    }
    
    // ... (method checkout, prosesCheckout, checkoutKeranjang TIDAK BERUBAH) ...
    public function checkout($produk_id) {
        $produk = Produk::findOrFail($produk_id);
        if ($produk->stok <= 0) {
            return redirect()->route('produk.show', $produk_id)->with('error', 'Stok produk habis.');
        }
        return view('transaksi.checkout', compact('produk'));
    }

    public function prosesCheckout(Request $request, $produk_id) {
        $produk = Produk::findOrFail($produk_id);
        $user = Auth::user();

        $request->validate([
            'jumlah' => 'required|numeric|min:1|max:' . $produk->stok,
            'alamat' => 'required|string',
        ], [
            'jumlah.max' => 'Jumlah pembelian melebihi stok yang tersedia.'
        ]);

        $jumlah = (int)$request->jumlah;
        $total = $produk->harga * $jumlah;

        // Ambil timestamp *sebelum* membuat transaksi untuk order_id
        $timestamp = time();

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'total_harga' => $total,
                'status' => 'menunggu pembayaran',
                'alamat_pengiriman' => $request->alamat,
                // 'order_id_midtrans' => 'TRX-' . $transaksi->id . '-' . $timestamp // Simpan order_id
            ]);

            // Simpan order_id setelah dapat $transaksi->id
            $order_id_midtrans = 'TRX-' . $transaksi->id . '-' . $timestamp;
            $transaksi->order_id_midtrans = $order_id_midtrans;
            
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produk->id,
                'jumlah' => $jumlah,
                'harga' => $produk->harga,
            ]);

            $item_details = [
                [
                    'id' => $produk->id,
                    'price' => $produk->harga,
                    'quantity' => $jumlah,
                    'name' => $produk->nama
                ]
            ];

            $snapToken = $this->buatMidtransSnapToken($transaksi, $user, $item_details, $order_id_midtrans);
            $transaksi->snap_token = $snapToken;
            $transaksi->save(); // Simpan snap_token dan order_id_midtrans

            DB::commit();
            return redirect()->route('transaksi.pembayaran', $transaksi->id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout Beli Langsung Error: ' . $e->getMessage());
            return redirect()->route('produk.show', $produk_id)->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }

    public function checkoutKeranjang(Request $request)
    {
        $user = Auth::user();
        $keranjangs = Keranjang::where('user_id', $user->id)->with('produk')->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate(['alamat' => 'required|string']);

        // Ambil timestamp *sebelum* membuat transaksi untuk order_id
        $timestamp = time();

        DB::beginTransaction();
        try {
            $total_bayar = 0;
            $item_details_midtrans = [];

            foreach ($keranjangs as $item) {
                if ($item->jumlah > $item->produk->stok) {
                    DB::rollBack();
                    return redirect()->route('keranjang.index')->with('error', 'Stok produk '.$item->produk->nama.' tidak mencukupi.');
                }
                $total_bayar += $item->jumlah * $item->produk->harga;
            }

            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'total_harga' => $total_bayar,
                'status' => 'menunggu pembayaran',
                'alamat_pengiriman' => $request->alamat,
            ]);

            // Simpan order_id setelah dapat $transaksi->id
            $order_id_midtrans = 'TRX-' . $transaksi->id . '-' . $timestamp;
            $transaksi->order_id_midtrans = $order_id_midtrans;

            foreach ($keranjangs as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->produk->harga,
                ]);

                $item_details_midtrans[] = [
                    'id' => $item->produk_id,
                    'price' => $item->produk->harga,
                    'quantity' => $item->jumlah,
                    'name' => $item->produk->nama
                ];
            }

            Keranjang::where('user_id', $user->id)->delete();

            $snapToken = $this->buatMidtransSnapToken($transaksi, $user, $item_details_midtrans, $order_id_midtrans);
            $transaksi->snap_token = $snapToken;
            $transaksi->save(); // Simpan snap_token dan order_id_midtrans

            DB::commit();
            return redirect()->route('transaksi.pembayaran', $transaksi->id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout Keranjang Error: ' . $e->getMessage());
            return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }

    // Ubah helper function untuk menerima $order_id_midtrans
    private function buatMidtransSnapToken($transaksi, $user, $item_details, $order_id_midtrans)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $payload = [
            'transaction_details' => [
                'order_id' => $order_id_midtrans, // Gunakan order_id yang konsisten
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $user->nama, 
                'email' => $user->email,
            ],
            'item_details' => $item_details,
            // Arahkan ke route konfirmasi
            'finish_redirect_url' => route('transaksi.konfirmasi', ['id' => $transaksi->id]), 
        ];

        return \Midtrans\Snap::getSnapToken($payload);
    }


    public function showPembayaran($id)
    {
        $transaksi = Transaksi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if($transaksi->status != 'menunggu pembayaran' && $transaksi->status != 'pending') {
            return redirect()->route('transaksi.show', $transaksi->id)->with('info', 'Transaksi ini sudah diproses.');
        }
        return view('transaksi.pembayaran', compact('transaksi'));
    }

    // Perbaikan di konfirmasiPembayaran untuk menggunakan order_id_midtrans
    public function konfirmasiPembayaran(Request $request, $id)
    {
        Log::info('Konfirmasi Pembayaran (Redirect) dipanggil untuk Transaksi ID: ' . $id);
        Log::info('Request data: ' . json_encode($request->all()));
        
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        
        $transaksi = Transaksi::with('details.produk')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // Cek jika order_id_midtrans ada
        if (empty($transaksi->order_id_midtrans)) {
            Log::error('Transaksi ID: ' . $id . ' tidak memiliki order_id_midtrans.');
            return redirect()->route('transaksi.show', $transaksi->id)->with('error', 'Gagal memverifikasi pembayaran. ID Pesanan Midtrans tidak ditemukan.');
        }

        try {
            // Ambil status terbaru dari Midtrans menggunakan order_id yang disimpan
            $statusMidtrans = \Midtrans\Transaction::status($transaksi->order_id_midtrans);
        } catch (Exception $e) {
            Log::error('Gagal cek status Midtrans API: ' . $e->getMessage());
            $statusMidtrans = null;
            $jsonCallback = json_decode($request->json, true); // Fallback ke JSON dari request
        }

        if ($transaksi->status != 'menunggu pembayaran' && $transaksi->status != 'pending') {
             Log::warning('Transaksi ID: ' . $id . ' sudah diproses sebelumnya. Status saat ini: ' . $transaksi->status);
             return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Pembayaran Anda sudah dikonfirmasi sebelumnya.');
        }

        $newStatus = $transaksi->status;
        $transactionStatus = $statusMidtrans ? $statusMidtrans->transaction_status : ($jsonCallback['transaction_status'] ?? null);
        $fraudStatus = $statusMidtrans ? $statusMidtrans->fraud_status : ($jsonCallback['fraud_status'] ?? null);

        if (empty($transactionStatus)) {
            Log::warning('Midtrans JSON Callback tidak lengkap/kosong untuk Transaksi ID: ' . $id);
            $newStatus = 'pending';
        } else {
            if ($transactionStatus == 'capture') {
                $newStatus = ($fraudStatus == 'accept') ? 'diproses' : 'challenge';
            } else if ($transactionStatus == 'settlement') {
                $newStatus = 'diproses';
            } else if (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
                $newStatus = 'dibatalkan';
            } else if ($transactionStatus == 'pending') {
                $newStatus = 'menunggu pembayaran';
            }
        }

        if ($newStatus == 'diproses') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::with('details.produk')->where('id', $id)->lockForUpdate()->first();
                if ($transaksi->status == 'menunggu pembayaran' || $transaksi->status == 'pending') {
                    
                    foreach ($transaksi->details as $detail) {
                        $produk = $detail->produk;
                        if (!$produk) {
                            throw new Exception('Produk dengan ID ' . $detail->produk_id . ' tidak ditemukan.');
                        }
                        if ($produk->stok < $detail->jumlah) {
                            throw new Exception('Stok untuk produk '. $produk->nama .' tidak mencukupi.');
                        }
                    }
                    foreach ($transaksi->details as $detail) {
                        if($detail->produk) {
                            $detail->produk->decrement('stok', $detail->jumlah);
                            Log::info('Stok produk ID ' . $detail->produk_id . ' dikurangi: ' . $detail->jumlah);
                        }
                    }
                    $transaksi->status = 'diproses';
                    $transaksi->save();
                    DB::commit();
                    Log::info('Transaksi ID: ' . $id . ' berhasil, status: diproses, stok dikurangi.');
                } else {
                    DB::rollBack();
                    Log::warning('Transaksi ID: ' . $id . ' sudah diproses (dideteksi saat lock). Status: ' . $transaksi->status);
                }
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Gagal mengurangi stok untuk Transaksi ID: ' . $id . '. Error: ' . $e->getMessage());
                $transaksi->status = 'gagal_stok'; 
                $transaksi->save();
                return redirect()->route('transaksi.show', $transaksi->id)->with('error', 'Pembayaran berhasil, tapi gagal mengupdate stok: ' . $e->getMessage());
            }
        } else {
            $transaksi->status = $newStatus;
            $transaksi->save();
            Log::info('Transaksi ID: ' . $id . ' status diupdate ke: ' . $newStatus . '. Stok tidak dikurangi.');
        }

        return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Pembayaran berhasil! Silakan konfirmasi pesanan Anda ke PLUT.');
    }


    // --- METHOD LAINNYA (TIDAK BERUBAH) ---
    public function pesanan() {
        if(Auth::user()->role == 'admin') {
            $pesanans = Transaksi::with(['details.produk', 'user'])->latest()->get();
        } 
        elseif (Auth::user()->role == 'penjual') {
            $pesanans = Transaksi::whereHas('details.produk', function($q) {
                $q->where('user_id', Auth::id());
            })->with('details.produk', 'user')->latest()->get();
        } 
        else {
            return redirect()->route('home')->withErrors('Akses ditolak.');
        }
        return view('transaksi.pesanan', compact('pesanans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
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
                'status' => 'required|in:menunggu pembayaran,diproses,dikirim,selesai,dibatalkan,pending,gagal_stok',
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
            in_array($transaksi->status, ['diproses', 'dikirim', 'selesai']) && 
            ( Auth::user()->role == 'admin' ||
            Auth::id() == $transaksi->user_id ||
            $isSeller
            )
        ) {
            $pdf = Pdf::loadView('transaksi.invoice', compact('transaksi'));
            return $pdf->download('invoice_pesanan_'.$transaksi->id.'.pdf');
        } else {
            return back()->withErrors('Invoice hanya bisa dicetak jika pesanan sudah dibayar/diproses.');
        }
    }
}

