<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'produk_id', 'jumlah', 'total_harga', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details() {
    return $this->hasMany(\App\Models\TransaksiDetail::class);
}

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
