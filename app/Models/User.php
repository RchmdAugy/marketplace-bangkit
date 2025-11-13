<?php

namespace App\Models;

// 1. IMPORT SoftDeletes DI SINI
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // 2. GUNAKAN SoftDeletes DI SINI
    use Notifiable, HasApiTokens, HasFactory, SoftDeletes; 

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