<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->text('alamat_pengiriman')->nullable();
        $table->string('snap_token')->nullable();
    });
}

public function down()
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->dropColumn([
            'alamat_pengiriman', 
            'snap_token'
        ]);
    });
}
};
