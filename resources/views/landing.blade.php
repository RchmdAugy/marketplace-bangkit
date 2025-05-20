@extends('layout.public')

@section('title', 'Selamat Datang')

@section('content')
<!-- HERO SECTION -->
<section class="hero bg-light">
    <div class="container">
        <h1 class="display-5">Selamat Datang di Marketplace BANGKIT</h1>
        <p class="mt-3 mb-4">Belanja produk unggulan dari penjual terpercaya hanya di satu tempat.</p>
        <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg px-4">Lihat Produk</a>
    </div>
</section>

<!-- FITUR SECTION -->
<section class="features container mt-5 mb-5">
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100">
                <i class="fa fa-box"></i>
                <h5 class="mt-3">Beragam Produk</h5>
                <p class="text-muted">Kami menyediakan berbagai kategori produk berkualitas.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <i class="fa fa-truck"></i>
                <h5 class="mt-3">Pengiriman Cepat</h5>
                <p class="text-muted">Pesanan Anda dikirim dengan cepat dan aman.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <i class="fa fa-users"></i>
                <h5 class="mt-3">Penjual Terpercaya</h5>
                <p class="text-muted">Hanya penjual yang telah diverifikasi dan terpercaya.</p>
            </div>
        </div>
    </div>
</section>
@endsection
