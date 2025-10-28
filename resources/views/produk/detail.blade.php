@extends('layout.public')
@section('title', $produk->nama)

@push('css')
<style>
    .product-gallery-thumbnails img { cursor: pointer; opacity: 0.6; transition: opacity 0.2s ease; border: 2px solid transparent; }
    .product-gallery-thumbnails img:hover,
    .product-gallery-thumbnails img.active { opacity: 1; border-color: var(--primary-color); }
    .product-main-image-container { height: 400px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; }
    .product-main-image-container img { max-height: 100%; max-width: 100%; object-fit: contain; }
    .product-no-image { height: 400px; }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row gx-lg-5 align-items-start">

                {{-- Bagian Galeri Gambar (Tidak Berubah) --}}
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="product-main-image-container border rounded-4 overflow-hidden shadow-sm mb-3">
                        @if($produk->foto)
                            <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk {{ $produk->nama }}" class="img-fluid" id="mainProductImage">
                        @elseif($produk->images->count() > 0)
                            <img src="{{ asset('foto_produk_gallery/'.$produk->images->first()->image_path) }}" alt="Foto Produk {{ $produk->nama }}" class="img-fluid" id="mainProductImage">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center w-100 product-no-image"><i class="fa fa-image fa-5x text-secondary"></i></div>
                        @endif
                    </div>
                    <div class="product-gallery-thumbnails d-flex flex-wrap gap-2">
                        @if($produk->foto)
                         <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Thumbnail 1" class="rounded border p-1 active" style="height: 60px; width: 60px; object-fit: cover;" onclick="changeMainImage('{{ asset('foto_produk/'.$produk->foto) }}', this)">
                         @endif
                        @foreach($produk->images as $index => $image)
                            <img src="{{ asset('foto_produk_gallery/'.$image->image_path) }}" alt="Thumbnail {{ $index + ($produk->foto ? 2 : 1) }}" class="rounded border p-1 {{ !$produk->foto && $index == 0 ? 'active' : '' }}" style="height: 60px; width: 60px; object-fit: cover;" onclick="changeMainImage('{{ asset('foto_produk_gallery/'.$image->image_path) }}', this)">
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-7">
                    <h1 class="display-6 fw-bold mb-1 text-secondary">{{ $produk->nama }}</h1>
                    @if($produk->category)
                        <span class="badge bg-primary-subtle text-primary-emphasis mb-3 fs-6 rounded-pill px-3 py-1">
                            <i class="fa fa-tag me-1"></i> {{ $produk->category->name }}
                        </span>
                    @endif

                    <div class="d-flex flex-wrap align-items-center mb-3 gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-store me-2 text-muted"></i>
                            <span class="text-muted fw-medium me-1">Penjual:</span>
                            <a href="{{ route('toko.show', $produk->user->id) }}" class="text-decoration-none fw-semibold text-primary">
                                {{ $produk->user->nama_toko ?? $produk->user->nama }}
                            </a>
                        </div>
                        
                        {{-- =================================== --}}
                        {{-- ==     BAGIAN RATING DIPERBAIKI    == --}}
                        {{-- =================================== --}}
                        <div class="d-flex align-items-center">
                            @php
                                // Definisikan variabel PHP di sini
                                $averageRating = $produk->reviews->avg('rating') ?? 0; // Tambah ?? 0 untuk jaga-jaga jika belum ada review
                                $roundedRating = round($averageRating);
                            @endphp

                            {{-- Loop Blade HARUS di luar @php --}}
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $roundedRating ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                            @endfor

                            {{-- Tampilkan angka rating --}}
                            <span class="fw-semibold text-dark ms-2">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-muted ms-1">({{ $produk->reviews->count() }} ulasan)</span>
                        </div>
                        {{-- =================================== --}}

                    </div>
                    <p class="fs-2 fw-bold text-primary mb-4">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                    <div class="d-flex align-items-center mb-4">
                        <span class="badge bg-secondary text-white p-2 fw-medium me-3"><i class="fa fa-box me-1"></i> Stok: {{ $produk->stok }}</span>
                        @if($produk->stok <= 0) <span class="text-danger fw-semibold">Produk Habis</span> @else <span class="text-success fw-semibold">Tersedia</span> @endif
                    </div>
                    {{-- Form Tambah Keranjang (Tidak Berubah) --}}
                    @if(Auth::check() && Auth::user()->role == 'pembeli' && $produk->stok > 0)
                        <form action="{{ route('keranjang.add', $produk->id) }}" method="POST" class="d-flex align-items-center gap-3"> @csrf <div class="input-group" style="width: 150px;"> <button type="button" class="btn btn-outline-secondary btn-sm" id="minus-btn">-</button> <input type="number" name="jumlah" id="jumlah-produk" value="1" min="1" max="{{ $produk->stok }}" class="form-control text-center quantity-input fw-semibold" readonly> <button type="button" class="btn btn-outline-secondary btn-sm" id="plus-btn">+</button> </div> <button class="btn btn-primary rounded-pill px-4 py-2 flex-grow-1" type="submit"> <i class="fa fa-cart-plus me-2"></i> Tambah ke Keranjang </button> </form>
                    @elseif(!Auth::check())
                        <div class="alert alert-info text-center"> <i class="fa fa-info-circle me-2"></i> Silakan <a href="{{ route('login') }}" class="alert-link fw-semibold">login</a> untuk menambahkan produk ke keranjang. </div>
                    @elseif(Auth::check() && Auth::user()->role == 'penjual' && Auth::user()->id == $produk->user_id)
                         <div class="alert alert-info text-center"> <i class="fa fa-info-circle me-2"></i> Ini adalah produk Anda. </div>
                    @else
                         <div class="alert alert-warning text-center"> <i class="fa fa-exclamation-triangle me-2"></i> Stok produk habis atau Anda tidak bisa membeli. </div>
                    @endif
                </div>
            </div>

            {{-- Tabs Deskripsi & Ulasan (Tidak Berubah) --}}
            <div class="mt-5 pt-4 border-top">
                <ul class="nav nav-pills product-tabs mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active fw-semibold" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi-tab-pane" type="button" role="tab">Deskripsi Produk</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link fw-semibold" id="ulasan-tab" data-bs-toggle="tab" data-bs-target="#ulasan-tab-pane" type="button" role="tab">Ulasan ({{ $produk->reviews->count() }})</button></li>
                </ul>
                <div class="tab-content" id="productTabsContent">
                    <div class="tab-pane fade show active p-3 bg-light rounded-3" id="deskripsi-tab-pane" role="tabpanel"><p class="text-muted mb-0" style="white-space: pre-wrap;">{{ $produk->deskripsi }}</p></div>
                    <div class="tab-pane fade p-3 bg-light rounded-3" id="ulasan-tab-pane" role="tabpanel">
                        @forelse($produk->reviews as $review)
                        <div class="review-item border-bottom pb-3 mb-3"> <div class="d-flex align-items-center mb-2"> <div class="avatar-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center fw-bold"> {{ substr($review->user->nama ?? 'P', 0, 1) }} </div> <div> <h6 class="fw-semibold mb-0 text-secondary">{{ $review->user->nama ?? 'Pengguna' }}</h6> <small class="text-body-secondary">{{ $review->created_at->diffForHumans() }}</small> </div> </div> <div class="mb-2"> @for ($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary opacity-25' }}"></i> @endfor </div> <p class="text-muted mb-0">{{ $review->komentar }}</p> </div>
                        @empty
                        <div class="alert alert-light text-center mb-0"> <i class="fa fa-info-circle me-2"></i> Belum ada ulasan untuk produk ini. </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script +/- jumlah (tidak berubah) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('jumlah-produk');
        const minusBtn = document.getElementById('minus-btn');
        const plusBtn = document.getElementById('plus-btn');

        if (quantityInput && minusBtn && plusBtn) {
            const maxStok = parseInt(quantityInput.max);
            minusBtn.addEventListener('click', function() { /* ... */ });
            plusBtn.addEventListener('click', function() { /* ... */ });
            quantityInput.addEventListener('change', function() { /* ... */ });
        }
    });
</script>

{{-- ========================================= --}}
{{-- ==  SCRIPT BARU UNTUK KLIK THUMBNAIL   == --}}
{{-- ========================================= --}}
<script>
    function changeMainImage(newImageSrc, clickedThumbnail) {
        // Ganti gambar utama
        const mainImage = document.getElementById('mainProductImage');
        if(mainImage) {
            mainImage.src = newImageSrc;
        }

        // Update class 'active' pada thumbnail
        const thumbnails = document.querySelectorAll('.product-gallery-thumbnails img');
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        clickedThumbnail.classList.add('active');
    }
</script>
@endpush