<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ReviewController extends Controller
{
    public function create($transaksi_id)
    {
        $transaksi = Transaksi::with('produk')->findOrFail($transaksi_id);

        // Validasi: transaksi milik user & status selesai
        if($transaksi->user_id != Auth::id() || $transaksi->status != 'selesai') {
            return redirect()->route('transaksi.index')->withErrors('Tidak bisa beri ulasan untuk transaksi ini.');
        }

        // Cek apakah sudah pernah review
        if(Review::where('transaksi_id', $transaksi_id)->exists()) {
            return redirect()->route('transaksi.index')->withErrors('Ulasan sudah dibuat untuk transaksi ini.');
        }

        return view('review.create', compact('transaksi'));
    }

    public function store(Request $request, $transaksi_id)
    {
        $transaksi = Transaksi::with('produk')->findOrFail($transaksi_id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'produk_id' => $transaksi->produk_id,
            'transaksi_id' => $transaksi_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Ulasan berhasil dikirim.');
    }
}
