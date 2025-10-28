<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function create($transaksi_id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($transaksi_id);

        if($transaksi->user_id != Auth::id()) {
            return redirect()->route('transaksi.index')->withErrors('Anda tidak memiliki akses ke transaksi ini.');
        }

        // UBAH DARI $transaksi->status_pembayaran MENJADI $transaksi->status
        // Dan pastikan nilai status 'selesai' sesuai dengan yang ada di database Anda
        if($transaksi->status != 'selesai') {
             return redirect()->route('transaksi.index')->withErrors('Transaksi belum selesai, ulasan tidak dapat diberikan.');
        }

        return view('review.create', compact('transaksi'));
    }

    public function store(Request $request, Transaksi $transaksi)
    {

        $reviewsData = []; // Akan menyimpan data {produk_id, rating, komentar} yang valid
        $validationRules = [];
        $validationMessages = [];

        foreach ($transaksi->details as $detail) {
            $produkId = $detail->produk->id;
            $ratingInputName = "rating_{$produkId}";
            $komentarInputName = "komentar_{$produkId}";

            // Jika input untuk produk ini ada di request
            if ($request->has($ratingInputName) && $request->has($komentarInputName)) {
                $reviewsData[$produkId] = [
                    'produk_id' => $produkId, // Simpan produk_id di sini
                    'rating' => $request->input($ratingInputName),
                    'komentar' => $request->input($komentarInputName),
                ];

                // Aturan validasi untuk rating dan komentar
                $validationRules["{$ratingInputName}"] = 'required|integer|min:1|max:5';
                $validationRules["{$komentarInputName}"] = 'required|string|min:5|max:500';

                // Aturan validasi UNIQUE secara terpisah untuk setiap produk_id
                // Kita akan membuat validator terpisah untuk unik ini
                // dan mengumpulkannya di luar loop utama, atau menanganinya dengan cara berbeda.
                // Untuk saat ini, kita bisa pindahkan Rule::unique ke tempat penyimpanan
            }
        }

        // Jika tidak ada data ulasan yang dikirim sama sekali
        if (empty($reviewsData)) {
            return redirect()->back()->withErrors(['no_review' => 'Tidak ada ulasan yang dikirimkan. Harap isi setidaknya satu ulasan.']);
        }

        // Lakukan validasi umum untuk rating dan komentar terlebih dahulu
        $validator = validator($request->all(), $validationRules, $validationMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Setelah validasi umum, lakukan validasi unik per produk dan simpan
        $allErrors = [];
        foreach ($reviewsData as $produkId => $data) {
            // Validasi unik untuk setiap produk_id yang akan disimpan
            // Ini akan memastikan kombinasi user_id, transaksi_id, produk_id unik
            $uniqueValidator = validator([
                'user_id' => Auth::id(),
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produkId,
            ], [
                'produk_id' => [
                    Rule::unique('reviews')->where(function ($query) use ($transaksi, $produkId) {
                        return $query->where('user_id', Auth::id())
                                     ->where('transaksi_id', $transaksi->id)
                                     ->where('produk_id', $produkId);
                    }),
                ],
            ], [
                'produk_id.unique' => "Anda sudah memberikan ulasan untuk produk '{$transaksi->details->firstWhere('produk_id', $produkId)->produk->nama}' pada transaksi ini.",
            ]);

            if ($uniqueValidator->fails()) {
                foreach ($uniqueValidator->errors()->all() as $error) {
                    $allErrors[] = $error;
                }
                continue; // Lanjutkan ke produk berikutnya jika sudah diulas
            }

            // Jika semua validasi berhasil dan belum ada ulasan, simpan
            Review::create([
                'user_id' => Auth::id(),
                'transaksi_id' => $transaksi->id,
                'produk_id' => $data['produk_id'],
                'rating' => $data['rating'],
                'komentar' => $data['komentar'],
            ]);
        }

        if (!empty($allErrors)) {
            // Jika ada error unik (misal: beberapa sudah diulas, beberapa belum)
            // Anda bisa pilih untuk menampilkan semua error atau hanya menginformasikan
            // bahwa beberapa ulasan tidak dapat disimpan.
            return redirect()->back()->withErrors($allErrors)->withInput()->with('partial_success', 'Beberapa ulasan berhasil disimpan, beberapa tidak karena sudah diulas.');
        }

        // Redirect kembali ke halaman review transaksi dengan pesan sukses
        return redirect()->route('review.create', $transaksi->id)->with('success', 'Ulasan Anda berhasil disimpan!');
    }
}