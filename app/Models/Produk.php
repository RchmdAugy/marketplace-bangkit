<?php
// File: app/Models/Produk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    // DIUBAH: Tambahkan 'category_id' di sini
    protected $fillable = [
        'nama', 
        'deskripsi', 
        'harga', 
        'stok', 
        'user_id', 
        'foto', 
        'is_approved',
        'category_id' // <-- BARU
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * =======================================
     * == TAMBAHKAN FUNGSI RELASI INI       ==
     * =======================================
     * Mendapatkan kategori dari produk ini.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}