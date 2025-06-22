<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_profil')->nullable()->after('password');
            $table->string('nama_toko')->nullable()->after('role');
            $table->string('no_telepon')->nullable()->after('nama_toko');
            $table->text('alamat_toko')->nullable()->after('no_telepon');
        });
    }
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_profil', 'nama_toko', 'no_telepon', 'alamat_toko']);
        });
    }
}