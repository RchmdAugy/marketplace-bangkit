<?php
// File: database/migrations/...._make_slider_buttons_nullable.php

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
        Schema::table('sliders', function (Blueprint $table) {
            // Mengubah kolom agar boleh NULL (nullable)
            $table->string('button_text')->nullable()->change();
            $table->string('button_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Mengembalikan seperti semula jika di-rollback
            $table->string('button_text')->nullable(false)->change();
            $table->string('button_link')->nullable(false)->change();
        });
    }
};