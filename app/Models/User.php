<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nama', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    public function produks()
{
    return $this->hasMany(Produk::class);
}

}
