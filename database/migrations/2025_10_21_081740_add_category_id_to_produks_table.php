<?php
// File: database/migrations/...._add_category_id_to_produks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Tambahkan kolom category_id setelah kolom 'user_id'
            // Kolom ini boleh null untuk sementara agar produk lama tidak error
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Hapus foreign key dan kolom jika migrasi di-rollback
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};