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
    Schema::create('produks', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->text('deskripsi');
        $table->decimal('harga', 10, 2);
        $table->integer('stok');
        $table->enum('status', ['pending', 'approved'])->default('pending');
        $table->unsignedBigInteger('user_id'); // Relasi Penjual (User)
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });


}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
