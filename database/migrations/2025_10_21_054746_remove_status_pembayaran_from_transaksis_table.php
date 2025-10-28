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
            // Pastikan kolom 'status_pembayaran' benar-benar ada sebelum mencoba menghapusnya
            if (Schema::hasColumn('transaksis', 'status_pembayaran')) {
                $table->dropColumn('status_pembayaran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Di sini Anda bisa menambahkan kolomnya kembali jika rollback diperlukan
            // Namun, karena keputusan untuk menghapusnya adalah final, mungkin tidak perlu
            // menambahkan kembali (kecuali Anda benar-benar mau).
            // Contoh jika ingin menambahkan kembali:
            // $table->string('status_pembayaran')->default('pending')->after('status');
        });
    }
};