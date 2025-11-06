<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'foto_profil',
        'role',
        'is_approved',
        'nama_toko',
        'no_telepon',
        'alamat_toko',
        // 'nomor_lisensi',  // Tambahkan ini
        // 'file_lisensi',   // Tambahkan ini
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke produk yang dimiliki oleh user (penjual).
     */
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}