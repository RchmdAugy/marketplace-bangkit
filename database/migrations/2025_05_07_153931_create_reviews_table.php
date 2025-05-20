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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('produk_id');
        $table->unsignedBigInteger('transaksi_id');
        $table->tinyInteger('rating'); // rating 1-5
        $table->text('komentar');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
        $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
