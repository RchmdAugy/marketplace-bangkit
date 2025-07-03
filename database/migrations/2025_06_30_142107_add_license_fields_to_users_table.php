<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLicenseFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_lisensi')->nullable()->after('alamat_toko');
            $table->string('file_lisensi')->nullable()->after('nomor_lisensi');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nomor_lisensi', 'file_lisensi']);
        });
    }
}