<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = ['transaksi_id', 'produk_id', 'jumlah', 'harga'];

    public function produk() {
    return $this->belongsTo(\App\Models\Produk::class);
    }
}