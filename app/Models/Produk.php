<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'deskripsi', 'harga', 'stok', 'user_id'];

    // Relasi: Produk dimiliki oleh User (penjual)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews() {
        return $this->hasMany(\App\Models\Review::class);
    }
}
