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
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #1abc9c;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 500;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            background-color: #ffffff;
            color: #1abc9c;
            border: 2px solid #1abc9c;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e9f7f5;
        }

        .hero {
            padding: 100px 20px;
            text-align: center;
            background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
            color: white;
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .features .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .features i {
            font-size: 2.5rem;
            color: #1abc9c;
            margin-bottom: 20px;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0 20px;
        }

        footer a {
            color: #ecf0f1;
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
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BANGKIT</a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="{{ route('produk.index') }}" class="nav-link">Produk</a></li>
                <li class="nav-item"><a href="{{ route('transaksi.index') }}" class="nav-link">Transaksi</a></li>

                @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'penjual')
                        <li class="nav-item"><a href="{{ route('pesanan.index') }}" class="nav-link">Pesanan</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                    @endif
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">Keluar</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Masuk</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
@yield('content')

<!-- Footer -->
<footer class="mt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Tentang Kami</h5>
                <p>Marketplace BANGKIT adalah platform yang mendukung UMKM Indonesia agar berkembang dan go digital.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Navigasi</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('produk.index') }}">Produk</a></li>
                    <li><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Kontak</h5>
                <p><i class="fas fa-envelope me-2"></i> support@bangkit.com</p>
                <p><i class="fas fa-phone me-2"></i> +62 812 3456 7890</p>
                <p><i class="fas fa-map-marker-alt me-2"></i> Subang, Jawa Barat</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Marketplace BANGKIT. All rights reserved.
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
