<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Teks besar: "Karya Tangan Penuh Cerita"
            $table->text('subtitle'); // Teks kecil: "Temukan keunikan..."
            $table->string('image'); // Nama file gambar
            $table->string('button_text')->default('Lihat'); // Teks di tombol: "Lihat Koleksi"
            $table->string('button_link')->default('/'); // URL tujuan saat tombol diklik
            $table->integer('order')->default(0); // Untuk mengurutkan slider
            $table->boolean('is_active')->default(true); // Untuk menyembunyikan/menampilkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
