<?php
// File: database/migrations/...._create_product_images_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel 'produks'
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('image_path'); // Nama file gambar galeri
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};