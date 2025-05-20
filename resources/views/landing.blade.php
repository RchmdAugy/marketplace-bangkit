
@extends('layout.public')

@section('title', 'Selamat Datang')

@section('content')
<!-- HERO SECTION -->
<section class="hero bg-primary text-white py-5 mb-5 shadow-sm">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Marketplace <span class="text-warning">BANGKIT</span></h1>
        <p class="lead mb-4">Belanja produk unggulan dari penjual terpercaya hanya di satu tempat.<br>Temukan kebutuhan Anda dengan mudah, aman, dan cepat!</p>
        <a href="{{ route('produk.index') }}" class="btn btn-warning btn-lg px-5 shadow"><i class="fa fa-shopping-bag me-2"></i>Lihat Produk</a>
    </div>
</section>

<!-- PRODUK SECTION -->
@if(isset($produks) && $produks->count())
<section class="container my-5">
    <h2 class="mb-4 fw-bold text-center">Produk Terbaru</h2>
    <div class="row g-4">
        @foreach($produks as $produk)
        <div class="col-md-4">
            <div class="card h-100 shadow border-0">
                @if($produk->foto)
                <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" class="card-img-top" style="object-fit:cover;max-height:220px;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:220px;">
                    <i class="fa fa-image fa-3x text-muted"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold">{{ $produk->nama }}</h5>
                    <p class="card-text text-muted mb-2">{{ Str::limit($produk->deskripsi, 60) }}</p>
                    <p class="card-text fw-bold fs-5 text-primary mb-3">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                    <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-outline-primary mt-auto w-100"><i class="fa fa-eye"></i> Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-5 text-center">
        <a href="{{ route('produk.index') }}" class="btn btn-outline-primary btn-lg px-5"><i class="fa fa-th-large"></i> Lihat Semua Produk</a>
    </div>
</section>
@endif

<!-- FITUR SECTION -->
<section class="features container my-5">
    <h2 class="mb-4 fw-bold text-center">Kenapa Pilih Marketplace BANGKIT?</h2>
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm py-4">
                <div class="mb-3">
                    <i class="fa fa-box-open fa-3x text-primary"></i>
                </div>
                <h5 class="fw-semibold">Beragam Produk</h5>
                <p class="text-muted">Pilih dari ribuan produk berkualitas dari berbagai kategori, sesuai kebutuhan Anda.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm py-4">
                <div class="mb-3">
                    <i class="fa fa-shipping-fast fa-3x text-success"></i>
                </div>
                <h5 class="fw-semibold">Pengiriman Cepat</h5>
                <p class="text-muted">Pesanan Anda dikirim dengan cepat, aman, dan dapat dilacak secara real-time.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm py-4">
                <div class="mb-3">
                    <i class="fa fa-user-shield fa-3x text-warning"></i>
                </div>
                <h5 class="fw-semibold">Penjual Terpercaya</h5>
                <p class="text-muted">Hanya penjual yang telah diverifikasi dan terpercaya yang dapat berjualan di sini.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="bg-light py-5 mt-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3">Gabung Sekarang dan Nikmati Pengalaman Berjualan Online di Subang</h3>
        <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5"><i class="fa fa-user-plus"></i> Daftar Gratis</a>
    </div>
</section>
@endsection