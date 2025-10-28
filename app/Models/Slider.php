<?php
// File: app/Models/Slider.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    /**
     * ================================================================
     * == TAMBAHKAN BAGIAN INI UNTUK MEMPERBAIKI ERROR MASS ASSIGNMENT ==
     * ================================================================
     *
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_link',
        'order',
        'is_active',
    ];
}