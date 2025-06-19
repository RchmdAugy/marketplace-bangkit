<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace BANGKIT - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
    :root {
        --primary-color: #10B981; /* Emerald-500, warna yang segar dan terpercaya */
        --primary-dark-color: #059669;
        --secondary-color: #334155; /* Slate-700, untuk teks & footer */
        --light-bg-color: #F8FAFC; /* Slate-50, background utama */
        --white-color: #ffffff;
        --border-color: #E2E8F0; /* Slate-200, untuk border */
        --shadow-color: rgba(0,0,0,0.05);
    }

    /* ... (CSS dasar dari jawaban sebelumnya tetap sama) ... */
    body { font-family: 'Poppins', sans-serif; background-color: var(--light-bg-color); }
    .navbar { background-color: var(--white-color); box-shadow: 0 4px 12px var(--shadow-color); border-bottom: 1px solid var(--border-color); }
    .navbar-brand, .navbar-brand i { color: var(--primary-dark-color) !important; font-weight: 700; }
    .nav-link { color: var(--secondary-color) !important; font-weight: 500; transition: color 0.2s ease; border-bottom: 2px solid transparent; }
    .nav-link:hover, .nav-link.active { color: var(--primary-color) !important; border-bottom-color: var(--primary-color); }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2); }
    .btn-primary:hover { background-color: var(--primary-dark-color); border-color: var(--primary-dark-color); transform: translateY(-2px); box-shadow: 0 7px 20px rgba(16, 185, 129, 0.3); }
    .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); font-weight: 600; transition: all 0.3s ease; }
    .btn-outline-primary:hover { background-color: var(--primary-color); color: var(--white-color); }
    .card { border: 1px solid var(--border-color); transition: all 0.3s ease-in-out; background-color: var(--white-color); }
    .card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.07) !important; transform: translateY(-5px); }
    footer { background-color: var(--secondary-color); color: #CBD5E1; padding: 50px 0 20px; }
    footer h5 { color: var(--white-color); }
    footer a { color: #CBD5E1; text-decoration: none; transition: color 0.2s; }
    footer a:hover { color: var(--primary-color); }
    .footer-bottom { border-top: 1px solid #475569; padding-top: 20px; margin-top: 30px; }

    /* ======================================================= */
    /* == CSS BARU UNTUK HERO SLIDER YANG LEBIH BAIK == */
    /* ======================================================= */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-slider .swiper-slide {
        height: 480px;
        background-size: cover;
        background-position: center;
        border-radius: 1.25rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        color: white;
    }

    .hero-slider .slide-content {
        padding: 0 4rem;
        position: relative;
        z-index: 10;
    }

    .hero-slider .slide-content > * {
        opacity: 0; /* Sembunyikan semua elemen konten secara default */
    }

    .swiper-slide-active .slide-content > * {
        animation: fadeInUp 0.8s ease forwards; /* Terapkan animasi saat slide aktif */
    }

    /* Atur delay animasi untuk setiap elemen */
    .swiper-slide-active .slide-content h1 { animation-delay: 0.3s; }
    .swiper-slide-active .slide-content p { animation-delay: 0.5s; }
    .swiper-slide-active .slide-content .btn { animation-delay: 0.7s; }
    
    .hero-slider .slide-content h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 0 3px 12px rgba(0,0,0,0.6);
    }

    .hero-slider .slide-content p {
        font-size: 1.1rem;
        max-width: 550px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.6);
    }

    /* Tombol Adaptif */
    .slide-button {
        --button-bg: var(--slide-theme-color, var(--primary-color));
        background-color: var(--button-bg);
        color: white;
        border: none;
        font-weight: 600;
        padding: 0.8rem 2rem;
        transition: all 0.3s ease;
    }
    .slide-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0,0,0,0.2);
        filter: brightness(1.1);
    }
    
    /* Tema Warna per Slide (KUNCI DARI PERMINTAAN ANDA) */
    .slide-theme-food { --slide-theme-color: #F97316; } /* Oranye Hangat */
    .slide-theme-craft { --slide-theme-color: #A855F7; } /* Ungu Kreatif */
    .slide-theme-coffee { --slide-theme-color: #8D6E63; } /* Coklat Kopi */

    /* Navigasi Swiper yang Dipercantik */
    .swiper-button-next, .swiper-button-prev { color: var(--white-color) !important; background-color: rgba(0,0,0,0.2); border-radius: 50%; width: 50px; height: 50px; transition: background-color 0.2s ease; }
    .swiper-button-next:hover, .swiper-button-prev:hover { background-color: rgba(0,0,0,0.4); }
    .swiper-button-next::after, .swiper-button-prev::after { font-size: 1.2rem !important; font-weight: 700; }
    .swiper-pagination-bullet { background: rgba(255, 255, 255, 0.5) !important; width: 10px; height: 10px; transition: all 0.2s ease; }
    .swiper-pagination-bullet-active { background: var(--white-color) !important; transform: scale(1.2); }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    {{-- Kode Navbar Anda di sini --}}
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}"><i class="fa fa-store fa-lg"></i><span style="letter-spacing:1px;">BANGKIT</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><i class="fa fa-bars text-secondary"></i></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                 @guest
                    <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Masuk</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Daftar</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li class="nav-item"><a href="{{ route('produk.index') }}" class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}">Produk</a></li>
                    @if(Auth::user()->role == 'pembeli')
                        <li class="nav-item"><a href="{{ route('transaksi.index') }}" class="nav-link">Transaksi</a></li>
                        <li class="nav-item position-relative"><a class="nav-link" href="{{ route('keranjang.index') }}"><i class="fa fa-shopping-cart"></i>
                            @php $keranjangCount = \App\Models\Keranjang::where('user_id', Auth::id())->count(); @endphp
                            @if($keranjangCount > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $keranjangCount }}</span>@endif
                        </a></li>
                    @endif
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Panel</a></li>
                    @elseif(Auth::user()->role == 'penjual')
                         <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard Penjual</a></li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-user-circle me-1"></i> {{ Auth::user()->nama }}</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profil.show') }}">Profil Saya</a></li>
                            @if(Auth::user()->role == 'penjual')
                                <li><a class="dropdown-item" href="{{ route('pesanan.index') }}">Pesanan Masuk</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Keluar</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="mt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-store me-2"></i>BANGKIT</h5>
                <p>Marketplace BANGKIT adalah platform yang mendukung UMKM Indonesia agar berkembang dan go digital.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Navigasi</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('produk.index') }}">Produk</a>
                    <a href="{{ route('transaksi.index') }}">Transaksi</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Kontak</h5>
                <p class="mb-2"><i class="fas fa-envelope me-2"></i> support@bangkit.com</p>
                <p class="mb-2"><i class="fas fa-phone me-2"></i> +62 812 3456 7890</p>
                <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Subang, Jawa Barat</p>
            </div>
        </div>
        <div class="footer-bottom text-center">
            &copy; {{ date('Y') }} Marketplace BANGKIT. All rights reserved.
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')
</body>
</html>