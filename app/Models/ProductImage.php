<?php
// File: app/Models/ProductImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'image_path',
    ];

    /**
     * Mendapatkan produk yang memiliki gambar ini.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}