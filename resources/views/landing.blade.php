@extends('layout.public')

@section('title', 'Produk Lokal, Kualitas Juara')

@section('content')

<div class="container mt-4 mb-5">
    <div class="swiper hero-slider" style="border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide-theme-food" style="background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.1)), url('{{ asset('images/foto_landing.webp') }}'); background-size: cover; background-position: center;">
                <div class="slide-content">
                    <h1 class="mb-3">Renyahnya Jajanan Khas Subang</h1>
                    <p class="mb-4">Keripik, kue kering, dan aneka camilan langsung dari dapurnya.</p>
                    <a href="{{ route('produk.index') }}" class="btn slide-button rounded-pill">
                        <i class="fa fa-shopping-bag me-2"></i>Belanja Sekarang
                    </a>
                </div>
            </div>
            <div class="swiper-slide slide-theme-craft" style="background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.1)), url('https://img.freepik.com/premium-photo/old-vietnamese-female-craftsman-making-traditional-bamboo-fish-trap_41418-1356.jpg?ga=GA1.1.1438699670.1732442037&semt=ais_hybrid&w=740'); background-size: cover; background-position: center;">
                <div class="slide-content">
                    <h1 class="mb-3">Karya Tangan Penuh Cerita</h1>
                    <p class="mb-4">Temukan keunikan dalam setiap detail kerajinan lokal.</p>
                    <a href="{{ route('produk.index') }}" class="btn slide-button rounded-pill">
                        <i class="fa fa-palette me-2"></i>Lihat Koleksi
                    </a>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="container my-5">
    
    @if(isset($produks) && $produks->count() > 0)
    <section class="my-5">
        <h2 class="mb-4 fw-bold text-center">Produk dari UMKM Pilihan</h2>
        <div class="row g-4">
            @foreach($produks as $produk)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    @if($produk->foto)
                    <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="{{ $produk->nama }}" class="card-img-top rounded-top-4" style="object-fit:cover; height:200px;">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height:200px;"><i class="fa fa-image fa-3x text-secondary"></i></div>
                    @endif
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title fw-semibold text-dark" style="font-size: 1rem;"><a href="{{ route('produk.show', $produk->id) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($produk->nama, 45) }}</a></h5>
                        <p class="small text-muted mb-2"><i class="fa fa-store me-1"></i> {{ $produk->user->nama_toko ?? $produk->user->nama }}</p>
                        <p class="fw-bold fs-5 text-primary mt-auto">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-5 text-center">
            <a href="{{ route('produk.index') }}" class="btn btn-primary rounded-pill px-5">
                <i class="fa fa-th-large"></i> Lihat Semua Produk
            </a>
        </div>
    </section>
    @else
    <section class="my-5 text-center">
         <div class="alert alert-light py-5">
            <h4>Belum Ada Produk Tersedia</h4>
            <p class="text-muted">Nantikan produk-produk UMKM terbaik akan segera hadir di sini!</p>
        </div>
    </section>
    @endif

    <section class="features my-5">
        </section>
</div>

@endsection

@push('scripts')
<script>
    // Inisialisasi Swiper.js untuk Hero Slider
    const swiper = new Swiper('.hero-slider', {
        loop: true,
        effect: 'fade', // Efek transisi yang lebih lembut
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
@endpush