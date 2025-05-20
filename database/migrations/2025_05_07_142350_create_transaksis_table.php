<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Pembeli
        $table->unsignedBigInteger('produk_id');
        $table->integer('jumlah');
        $table->decimal('total_harga', 10, 2);
        $table->enum('status', ['menunggu pembayaran', 'diproses', 'dikirim', 'selesai'])->default('menunggu pembayaran');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
