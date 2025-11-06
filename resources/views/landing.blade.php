@extends('layout.public')
@section('title', 'Produk Lokal, Kualitas Juara')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .hero-slider .slide-content { min-height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; }
    .hero-slider .swiper-button-next, .hero-slider .swiper-button-prev { color: rgba(255,255,255,0.7); transition: color 0.2s ease; }
    .hero-slider:hover .swiper-button-next, .hero-slider:hover .swiper-button-prev { color: rgba(255,255,255,1); }
    .hero-slider .swiper-pagination-bullet { background-color: rgba(255,255,255,0.5); width: 10px; height: 10px; opacity: 1; transition: background-color 0.2s ease;}
    .hero-slider .swiper-pagination-bullet-active { background-color: white; }

    .product-card-hover { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .product-card-hover:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important; }
    .product-card-img { object-fit: cover; height: 200px; } /* Pastikan tinggi gambar konsisten */
    .product-card-placeholder { height: 200px; }
</style>
@endpush

@section('content')

{{-- Slider (Tidak Berubah) --}}
<div class="container mt-4 mb-5">
    <div class="swiper hero-slider shadow-lg rounded-4 overflow-hidden">
        <div class="swiper-wrapper">
            @forelse($sliders as $slider)
            <div class="swiper-slide" style="background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.1)), url('{{ asset('foto_slider/'.$slider->image) }}'); background-size: cover; background-position: center;">
                <div class="slide-content text-white p-5">
                    <h1 class="mb-3 display-4 fw-bold animate__animated animate__fadeInDown">{{ $slider->title }}</h1>
                    <p class="mb-4 fs-5 animate__animated animate__fadeInUp animate__delay-0_5s">{{ $slider->subtitle }}</p>
                    @if($slider->button_text)
                    <a href="{{ $slider->button_link ?? '#' }}" class="btn btn-lg btn-primary rounded-pill animate__animated animate__pulse animate__delay-1s animate__infinite">
                        {{ $slider->button_text }} <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="swiper-slide" style="background: linear-gradient(to right, rgba(25, 135, 84, 0.8), rgba(25, 135, 84, 0.2)), url('{{ asset('images/foto_landing.webp') }}'); background-size: cover; background-position: center;">
                <div class="slide-content text-white p-5">
                    <h1 class="mb-3 display-4 fw-bold">Selamat Datang di BANGKIT</h1>
                    <p class="mb-4 fs-5">Temukan produk UMKM Subang terbaik di sini.</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-lg btn-light text-primary rounded-pill fw-bold shadow-sm">
                        <i class="fa fa-shopping-bag me-2"></i> Belanja Sekarang
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>

{{-- Section Produk Unggulan --}}
<div class="container my-5">
    {{-- =============================================== --}}
    {{-- ==  PASTIKAN MENGGUNAKAN $produksUnggulan    == --}}
    {{-- =============================================== --}}
    @if(isset($produksUnggulan) && $produksUnggulan->count() > 0)
    <section class="my-5">
        <h2 class="mb-4 fw-bold text-center text-secondary">Produk UMKM Unggulan</h2>

        <div class="row g-4">
            {{-- Loop produk unggulan --}}
            @foreach($produksUnggulan as $produk)
            <div class="col-6 col-md-4 col-lg-3 d-flex">
                <div class="card h-100 shadow-sm border-0 rounded-4 product-card-hover w-100">
                    <a href="{{ route('produk.show', $produk->id) }}" class="text-decoration-none d-flex flex-column h-100">
                        @php
                            $imagePath = null;
                            if ($produk->foto && file_exists(public_path('foto_produk/' . $produk->foto))) {
                                $imagePath = asset('foto_produk/' . $produk->foto);
                            } elseif ($produk->images->first() && file_exists(public_path('foto_produk_gallery/' . $produk->images->first()->image_path))) {
                                $imagePath = asset('foto_produk_gallery/' . $produk->images->first()->image_path);
                            }
                        @endphp
                        @if($imagePath)
                        <img src="{{ $imagePath }}" alt="{{ $produk->nama }}" class="card-img-top rounded-top-4 product-card-img">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4 product-card-placeholder"><i class="fa fa-image fa-3x text-secondary opacity-50"></i></div>
                        @endif

                        <div class="card-body d-flex flex-column p-3 flex-grow-1">
                            <h5 class="card-title fw-semibold text-dark mb-1" style="font-size: 1rem; min-height: 48px; line-height: 1.2;">
                                {{ Str::limit($produk->nama, 45) }}
                            </h5>

                            @if($produk->category)
                            <span class="badge bg-light text-secondary rounded-pill px-2 py-1 mb-2 align-self-start" style="font-size: 0.75rem;">{{ $produk->category->name }}</span>
                            @endif

                            <p class="small text-muted mb-2">
                                <i class="fa fa-store me-1 opacity-75"></i>
                                {{ $produk->nama_umkm ?? ($produk->user->nama_toko ?? $produk->user->nama) }}
                            </p>

                            <p class="fw-bold fs-5 text-primary mt-auto mb-0">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                            @if($produk->stok <= 0)
                                <span class="badge bg-danger-subtle text-danger-emphasis fw-semibold mt-2 align-self-start">Stok Habis</span>
                             @endif
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tombol Lihat Semua Produk --}}
        <div class="mt-5 text-center">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-semibold shadow-sm"> <i class="fa fa-th-large me-2"></i> Lihat Semua Produk </a>
        </div>
    </section>
    @else
    {{-- Jika tidak ada produk sama sekali --}}
    <section class="my-5 text-center">
         <div class="alert alert-light py-5 border-0 shadow-sm rounded-4">
             <i class="fas fa-box-open fa-3x mb-3 text-secondary opacity-50"></i>
             <h4 class="fw-bold text-secondary">Belum Ada Produk Tersedia</h4>
             <p class="text-muted mb-0">Nantikan produk-produk UMKM terbaik akan segera hadir di sini!</p>
         </div>
    </section>
    @endif
</div>
@endsection

@push('scripts')
{{-- Script Swiper --}}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.hero-slider', {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        keyboard: { enabled: true },
    });
</script>
@endpush