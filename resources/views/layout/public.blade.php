<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace BANGKIT - @yield('title', 'UMKM Naik Kelas')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        :root {
            --primary-color: #10B981; /* Emerald-500 */
            --primary-dark-color: #059669;
            --secondary-color: #334155; /* Slate-700 */
            --light-bg-color: #F8FAFC; /* Slate-50 */
            --white-color: #ffffff;
            --border-color: #E2E8F0; /* Slate-200 */
            --shadow-color: rgba(0,0,0,0.05);
        }
        body { font-family: 'Poppins', sans-serif; background-color: var(--light-bg-color); }
        .fw-medium { font-weight: 500 !important; }
        .fw-semibold { font-weight: 600 !important; }
        .fw-bold { font-weight: 700 !important; }
        .text-primary { color: var(--primary-color) !important; }
        .navbar { background-color: var(--white-color); box-shadow: 0 4px 12px var(--shadow-color); border-bottom: 1px solid var(--border-color); padding: 0.75rem 0; }
        .navbar-brand, .navbar-brand i { color: var(--primary-dark-color) !important; font-weight: 700; }
        .nav-link { font-weight: 500; transition: color 0.2s ease; border-bottom: 3px solid transparent; }
        .nav-link:hover, .nav-link.active { color: var(--primary-color) !important; }
        .navbar-desktop .nav-link { color: var(--secondary-color) !important; margin: 0 0.5rem; }
        .navbar-desktop .nav-link.active { border-bottom-color: var(--primary-color); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2); }
        .btn-primary:hover { background-color: var(--primary-dark-color); border-color: var(--primary-dark-color); transform: translateY(-2px); box-shadow: 0 7px 20px rgba(16, 185, 129, 0.3); }
        .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); font-weight: 600; transition: all 0.3s ease; }
        .btn-outline-primary:hover { background-color: var(--primary-color); color: var(--white-color); }
        .card { border: 1px solid var(--border-color); transition: all 0.3s ease-in-out; background-color: var(--white-color); }
        .card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.07) !important; transform: translateY(-5px); }
        .hero-slider .swiper-slide { height: 480px; background-size: cover; background-position: center; border-radius: 1.25rem; overflow: hidden; display: flex; align-items: center; color: white; }
        .hero-slider .slide-content { padding: 0 4rem; position: relative; z-index: 10; }
        .hero-slider .slide-content h1 { font-size: 3.5rem; font-weight: 700; text-shadow: 0 3px 12px rgba(0,0,0,0.6); }
        footer { background-color: var(--secondary-color); color: #CBD5E1; padding: 50px 0 20px; }

        @media (max-width: 991.98px) {
            .navbar-desktop { display: none; }
        }
        @media (min-width: 992px) {
            .navbar-mobile-toggler { display: none; }
        }
        @media (max-width: 767.98px) {
            .hero-slider .slide-content { padding: 0 2rem; }
            .hero-slider .slide-content h1 { font-size: 2.2rem; }
            .footer .text-md-start { text-align: center !important; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}"><i class="fa fa-store fa-lg"></i><span style="letter-spacing:1px;">BANGKIT</span></a>
        <button class="navbar-toggler navbar-mobile-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavbar"><span class="navbar-toggler-icon"></span></button>
        <div class="navbar-desktop w-100">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                @include('layout.partials._navbar_items')
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNavbar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
             @include('layout.partials._navbar_items')
        </ul>
    </div>
</div>

<main class="py-4">
    @yield('content')
</main>

<footer class="mt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-4 mb-4"><h5 class="fw-bold mb-3"><i class="fa fa-store me-2"></i>BANGKIT</h5><p>Marketplace BANGKIT adalah platform yang mendukung UMKM Indonesia agar berkembang dan go digital.</p></div>
            <div class="col-md-4 mb-4"><h5 class="fw-bold mb-3">Navigasi</h5><div class="d-flex flex-column gap-2"><a href="{{ route('home') }}">Beranda</a><a href="{{ route('produk.index') }}">Produk</a></div></div>
            <div class="col-md-4 mb-4"><h5 class="fw-bold mb-3">Kontak</h5><p class="mb-2"><i class="fas fa-envelope me-2"></i> support@bangkit.com</p><p class="mb-2"><i class="fas fa-phone me-2"></i> +62 812 3456 7890</p><p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Subang, Jawa Barat</p></div>
        </div>
        <div class="footer-bottom text-center border-top pt-3 mt-3">&copy; {{ date('Y') }} Marketplace BANGKIT. All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')
</body>
</html>