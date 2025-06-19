<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsApprovedToProduksTable extends Migration
{
    public function up()
    {
        Schema::table('produks', function (Blueprint $table) {
            // Menambahkan kolom is_approved setelah kolom stok
            // default(false) berarti setiap produk baru otomatis menunggu persetujuan
            $table->boolean('is_approved')->default(false)->after('stok');
        });
    }

    public function down()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
    }
}