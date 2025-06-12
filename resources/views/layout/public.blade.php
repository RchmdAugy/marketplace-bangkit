<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Marketplace BANGKIT - @yield('title')</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1abc9c;
            --primary-dark-color: #16a085;
            --secondary-color: #2c3e50;
            --light-bg-color: #f8f9fa;
            --white-color: #ffffff;
            --border-color: #e0e0e0;
            --shadow-color: rgba(0,0,0,0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg-color);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .navbar-brand, .nav-link {
            color: var(--white-color) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            background-color: var(--white-color);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        .hero {
            padding: 100px 20px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark-color) 100%);
            color: var(--white-color);
        }

        .hero h1 {
            font-weight: 800;
            font-size: 3rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 15px;
        }

        .features {
            padding: 60px 0;
        }

        .features .card {
            border: none;
            border-radius: 16px;
            padding: 30px 20px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .features .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px var(--shadow-color);
        }

        .features i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        footer {
            background-color: var(--secondary-color);
            color: var(--white-color);
            padding: 40px 0 20px;
        }

        footer a {
            color: var(--white-color);
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #7f8c8d;
            font-size: 0.9rem;
        }
        .card:hover { 
            box-shadow: 0 8px 32px rgba(26,188,156,0.15) !important; 
            transform: translateY(-4px); 
            transition: .2s; 
        }
        
        /* Tambahan untuk konsistensi */
        /* Menghapus override warna teks untuk h1-h6 agar tidak menyatu dengan background */
        /* .text-primary, h1, h2, h3, h4, h5, h6 {
            color: var(--primary-color) !important;
        } */
        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }
        .table-primary {
            --bs-table-bg: var(--primary-color);
            --bs-table-border-color: var(--primary-dark-color);
            color: var(--white-color);
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(26, 188, 156, 0.25);
        }

    </style>
</head>
<body>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
            <i class="fa fa-store fa-lg text-white"></i>
            <span style="letter-spacing:2px;">BANGKIT</span>
        </a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-1">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link" title="Beranda">
                        <i class="fa fa-home"></i>
                        <span class="d-none d-md-inline">Beranda</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produk.index') }}" class="nav-link" title="Produk">
                        <i class="fa fa-th-large"></i>
                        <span class="d-none d-md-inline">Produk</span>
                    </a>
                </li>
                @auth
                    @if(Auth::user()->role == 'pembeli')
                        <li class="nav-item">
                            <a href="{{ route('transaksi.index') }}" class="nav-link" title="Transaksi">
                                <i class="fa fa-receipt"></i>
                                <span class="d-none d-md-inline">Transaksi</span>
                            </a>
                        </li>
                        @php
                            $keranjangCount = \App\Models\Keranjang::where('user_id', Auth::id())->count();
                        @endphp
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="{{ route('keranjang.index') }}" title="Keranjang">
                                <i class="fa fa-shopping-cart"></i>
                                @if($keranjangCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $keranjangCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'penjual')
                        <li class="nav-item">
                            <a href="{{ route('pesanan.index') }}" class="nav-link" title="Pesanan">
                                <i class="fa fa-inbox"></i>
                                <span class="d-none d-md-inline">Pesanan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link" title="Dashboard">
                                <i class="fa fa-chart-bar"></i>
                                <span class="d-none d-md-inline">Dashboard</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('profil.show') }}" class="nav-link" title="Profil">
                            <i class="fa fa-user-circle"></i>
                            <span class="d-none d-md-inline">Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" title="Keluar">
                            <i class="fa fa-sign-out-alt"></i>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link" title="Masuk">
                            <i class="fa fa-sign-in-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link" title="Daftar">
                            <i class="fa fa-user-plus"></i>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- ... Main Content ... -->
@yield('content')

<!-- Footer -->
<footer class="mt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-store text-primary me-2"></i>Bangkit</h5>
                <p class="mb-2">Marketplace BANGKIT adalah platform yang mendukung UMKM Indonesia agar berkembang dan go digital.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-compass text-primary me-2"></i>Navigasi</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('home') }}"><i class="fa fa-home me-2"></i>Beranda</a>
                    <a href="{{ route('produk.index') }}"><i class="fa fa-th-large me-2"></i>Produk</a>
                    <a href="{{ route('transaksi.index') }}"><i class="fa fa-receipt me-2"></i>Transaksi</a>
                    @auth
                        <a href="{{ route('profil.show') }}"><i class="fa fa-user-circle me-2"></i>Profil</a>
                    @endauth
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-address-book text-primary me-2"></i>Kontak</h5>
                <p class="mb-2"><i class="fas fa-envelope me-2"></i> support@bangkit.com</p>
                <p class="mb-2"><i class="fas fa-phone me-2"></i> +62 812 3456 7890</p>
                <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Subang, Jawa Barat</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Marketplace BANGKIT. s reserved.
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
