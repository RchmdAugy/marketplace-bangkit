<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN INI

class KeranjangController extends Controller
{
    public function index() {
        $items = Keranjang::where('user_id', Auth::id())->with('produk')->get();
        return view('keranjang.index', compact('items'));
    }

    public function add(Request $request, $produk_id) {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        $produk = Produk::findOrFail($produk_id);
        $jumlahDiminta = (int)$request->jumlah;

        // 1. Cek apakah stok produk mencukupi
        if ($produk->stok < $jumlahDiminta) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Cek apakah item sudah ada di keranjang
        $keranjang = Keranjang::where('user_id', Auth::id())
                            ->where('produk_id', $produk_id)
                            ->first();

        if ($keranjang) {
            // Jika sudah ada, cek apakah totalnya akan melebihi stok
            $jumlahBaru = $keranjang->jumlah + $jumlahDiminta;
            if ($produk->stok < $jumlahBaru) {
                return back()->with('error', 'Gagal menambahkan. Jumlah di keranjang Anda melebihi stok yang tersedia.');
            }
            // Update jumlah
            $keranjang->jumlah = $jumlahBaru;
            $keranjang->save();
        } else {
            // Jika item baru, buat entri baru
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk_id,
                'jumlah' => $jumlahDiminta
            ]);
        }
        
        return redirect()->route('keranjang.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function remove($id) {
        Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * PERUBAHAN BESAR DI SINI:
     * Method ini diubah untuk mengembalikan JSON agar sesuai dengan
     * JavaScript AJAX di halaman keranjang.index.blade.php
     */
    public function update(Request $request, $id) {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        
        $keranjang = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $produk = $keranjang->produk; // Ambil relasi produk
        $jumlahDiminta = (int)$request->jumlah;
        
        // 1. Validasi Stok
        if ($produk->stok < $jumlahDiminta) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Hanya tersisa ' . $produk->stok . ' unit.',
                'old_jumlah' => $keranjang->jumlah // Kembalikan jumlah lama
            ]);
        }

        // 2. Update Jumlah jika stok aman
        $keranjang->jumlah = $jumlahDiminta;
        $keranjang->save();

        // 3. Hitung ulang total untuk dikirim kembali ke JavaScript
        $newSubtotal = $produk->harga * $keranjang->jumlah;
        
        // Ambil semua item keranjang milik user untuk menghitung grand total
        $allItems = Keranjang::where('user_id', Auth::id())->with('produk')->get();
        $grandTotal = $allItems->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        $totalItemsCount = $allItems->sum('jumlah');

        // 4. Kembalikan Respon JSON
        return response()->json([
            'success' => true,
            'new_subtotal' => $newSubtotal,
            'grand_total' => $grandTotal,
            'total_items_count' => $totalItemsCount
        ]);
    }
}
