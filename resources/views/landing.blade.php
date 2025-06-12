@extends('layout.public')

@section('title', 'Selamat Datang')

@section('content')
<!-- HERO SECTION -->
<section class="hero py-5 mb-5 shadow-sm">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Marketplace <span class="text-warning">BANGKIT</span></h1>
        <p class="lead mb-4">Belanja produk unggulan dari penjual terpercaya hanya di satu tempat.<br>Temukan kebutuhan Anda dengan mudah, aman, dan cepat!</p>
        <a href="{{ route('produk.index') }}" class="btn btn-light btn-lg px-5 shadow rounded-pill text-primary fw-bold">
            <i class="fa fa-shopping-bag me-2"></i>Lihat Produk
        </a>
    </div>
</section>

<!-- PRODUK SECTION -->
@if(isset($produks) && $produks->count())
<section class="container my-5">
    <h2 class="mb-4 fw-bold text-center">Produk Terbaru</h2>
    <div class="row g-4">
        @foreach($produks as $produk)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                @if($produk->foto)
                <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" class="card-img-top rounded-top-4" style="object-fit:cover;max-height:220px;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height:220px;">
                    <i class="fa fa-image fa-3x text-secondary"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold text-dark">{{ $produk->nama }}</h5>
                    <p class="text-muted small mb-2">{{ Str::limit($produk->deskripsi, 60) }}</p>
                    <p class="fw-bold fs-5">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                    <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-outline-primary w-100 mt-auto rounded-pill">
                        <i class="fa fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-5 text-center">
        <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
            <i class="fa fa-th-large"></i> Lihat Semua Produk
        </a>
    </div>
</section>
@endif

<!-- FITUR SECTION -->
<section class="features container my-5">
    <h2 class="mb-4 fw-bold text-center">Kenapa Pilih Marketplace BANGKIT?</h2>
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm py-4 px-3 rounded-4">
                <div class="mb-3">
                    <i class="fa fa-box-open fa-3x"></i>
                </div>
                <h5 class="fw-semibold">Beragam Produk</h5>
                <p class="text-muted">Pilih dari ribuan produk berkualitas dari berbagai kategori, sesuai kebutuhan Anda.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm py-4 px-3 rounded-4">
                <div class="mb-3">
                    <i class="fa fa-shipping-fast fa-3x"></i>
                </div>
                <h5 class="fw-semibold">Pengiriman Cepat</h5>
                <p class="text-muted">Pesanan Anda dikirim dengan cepat, aman, dan dapat dilacak secara real-time.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm py-4 px-3 rounded-4">
                <div class="mb-3">
                    <i class="fa fa-user-shield fa-3x"></i>
                </div>
                <h5 class="fw-semibold">Penjual Terpercaya</h5>
                <p class="text-muted">Hanya penjual yang telah diverifikasi dan terpercaya yang dapat berjualan di sini.</p>
            </div>
        </div>
    </div>
</section>
@endsection
