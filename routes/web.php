<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;

use App\Http\Controllers\Admin\UserApprovalController;


    Route::get('/admin/approval', [UserApprovalController::class, 'index'])->name('admin.approval');
    Route::post('/admin/approval/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.approval.approve');



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/{id}/update', [ProdukController::class, 'update'])->name('produk.update');
    Route::get('/produk/{id}/delete', [ProdukController::class, 'destroy'])->name('produk.delete');

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/checkout/{produk_id}', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{produk_id}', [TransaksiController::class, 'prosesCheckout'])->name('checkout.proses');
    Route::get('/transaksi/{id}/invoice', [TransaksiController::class, 'cetakInvoice'])->name('transaksi.invoice');

    // Transaksi admin & seller
    Route::get('/pesanan', [TransaksiController::class, 'pesanan'])->name('pesanan.index');
    Route::post('/pesanan/{id}/update-status', [TransaksiController::class, 'updateStatus'])->name('pesanan.updateStatus');

    Route::get('/review/{transaksi_id}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{transaksi_id}/store', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{produk_id}/add', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::post('/keranjang/{id}/update', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::get('/keranjang/{id}/remove', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    // Checkout dari keranjang
    Route::post('/keranjang/checkout', [TransaksiController::class, 'checkoutKeranjang'])->name('keranjang.checkout');

    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [App\Http\Controllers\ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/update', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
});
