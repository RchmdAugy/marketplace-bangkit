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
        Schema::table('transaksis', function (Blueprint $table) {
            // Tambahkan kolom baru untuk menyimpan order_id unik Midtrans
            // 'nullable' agar data lama tidak error, 'after' agar rapi (opsional)
            $table->string('order_id_midtrans')->nullable()->after('snap_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kolomnya jika migrasi di-rollback
            $table->dropColumn('order_id_midtrans');
        });
    }
};
