<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminBaseController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }
    }
}