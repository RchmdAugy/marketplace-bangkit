<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // TAMBAHKAN 'is_approved' DI SINI
    protected $fillable = ['nama', 'deskripsi', 'harga', 'stok', 'user_id', 'foto', 'is_approved'];

    // TAMBAHKAN INI UNTUK MEMASTIKAN TIPE DATA BENAR
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews() {
        return $this->hasMany(\App\Models\Review::class);
    }
}