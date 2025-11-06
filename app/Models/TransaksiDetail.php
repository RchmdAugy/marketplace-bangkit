<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = ['transaksi_id', 'produk_id', 'jumlah', 'harga'];

    // Relasi ke Produk
    public function produk() {
        // Gunakan ::class untuk namespace yang lebih aman
        return $this->belongsTo(Produk::class);
    }

    // --- TAMBAHKAN RELASI INI ---
    // Relasi ke Transaksi (Induk)
    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
    // --- AKHIR TAMBAHAN ---
}