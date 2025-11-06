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
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {
    // Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/produk/kategori/{category:slug}', [ProdukController::class, 'index'])->name('produk.by_category');

    // Transaksi Pembeli
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/checkout/{produk_id}', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{produk_id}', [TransaksiController::class, 'prosesCheckout'])->name('checkout.proses');
    Route::get('/transaksi/{id}/invoice', [TransaksiController::class, 'cetakInvoice'])->name('transaksi.invoice');
    Route::get('/transaksi/{id}/pembayaran', [TransaksiController::class, 'showPembayaran'])->name('transaksi.pembayaran');
    Route::post('/transaksi/{id}/konfirmasi', [TransaksiController::class, 'konfirmasiPembayaran'])->name('transaksi.konfirmasi');

    // Transaksi Admin & Seller (using pesanan.updateStatus)
    Route::get('/pesanan', [TransaksiController::class, 'pesanan'])->name('pesanan.index');
    Route::post('/pesanan/{id}/update-status', [TransaksiController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // Review
    Route::get('/review/{transaksi_id}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{transaksi}/store', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

    // Dashboard (corrected to statistik method)
    Route::get('/dashboard', [DashboardController::class, 'statistik'])->name('dashboard');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{produk_id}/add', [KeranjangController::class, 'add'])->name('keranjang.add');
    
    // --- INI PERBAIKANNYA ---
    // Ubah Route::post menjadi Route::put
    Route::put('/keranjang/{id}/update', [KeranjangController::class, 'update'])->name('keranjang.update');
    // --- AKHIR PERBAIKAN ---

    Route::delete('/keranjang/{id}/remove', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    Route::post('/keranjang/checkout', [TransaksiController::class, 'checkoutKeranjang'])->name('keranjang.checkout');

    // Profil
    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [App\Http\Controllers\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/toko/{id}', [App\Http\Controllers\TokoController::class, 'show'])->name('toko.show');
});

Route::prefix('admin')->name('admin.')->group(function () {


        // --- TAMBAHKAN RUTE INI ---
        Route::get('/profil', [App\Http\Controllers\Admin\AdminProfilController::class, 'show'])->name('profil.show');
        // Anda bisa tambahkan edit/update nanti jika perlu
        // Route::get('/profil/edit', [App\Http\Controllers\Admin\AdminProfilController::class, 'edit'])->name('profil.edit');
        // Route::put('/profil', [App\Http\Controllers\Admin\AdminProfilController::class, 'update'])->name('profil.update');
        // --- BATAS PENAMBAHAN ---

        // Fitur Persetujuan Penjual (yang sudah ada, dipindahkan ke sini)
        // Route::get('/approval', [App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('approval');
        // Route::post('/approval/{id}/approve', [App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('approval.approve');

        // CRUD Slider Baru
        Route::resource('sliders', SliderController::class);

        // CRUD Kategori Baru
        Route::resource('categories', CategoryController::class)->except(['show']); // Kita tidak butuh halaman 'show'

        // Dashboard Admin Baru
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Kelola User (CRUD)
        Route::get('/users', [App\Http\Controllers\Admin\KelolaUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\Admin\KelolaUserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\Admin\KelolaUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\KelolaUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\Admin\KelolaUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\KelolaUserController::class, 'destroy'])->name('users.destroy');

        // Laporan Penjualan
        Route::get('/laporan/penjualan', [App\Http\Controllers\Admin\LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        // --- RUTE BARU UNTUK DETAIL ---
        Route::get('/laporan/penjualan/{penjual}', [App\Http\Controllers\Admin\LaporanController::class, 'detailProduk'])->name('laporan.penjualan.detail');
        // --- AKHIR RUTE BARU ---

        Route::get('/produk/approval', [App\Http\Controllers\Admin\ProdukApprovalController::class, 'index'])->name('produk.approval');
        Route::post('/produk/approval/{produk}/approve', [App\Http\Controllers\Admin\ProdukApprovalController::class, 'approve'])->name('produk.approve');
    });
