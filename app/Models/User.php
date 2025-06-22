<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'foto_profil',      // Ditambahkan
        'role',
        'is_approved',
        'nama_toko',   // Ditambahkan
        'no_telepon',   // Ditambahkan
        'alamat_toko',  // Ditambahkan
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