<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            --text-color: #475569; /* Slate-600 untuk teks umum */
            --light-bg-color: #F8FAFC; /* Slate-50 */
            --white-color: #ffffff;
            --border-color: #E2E8F0; /* Slate-200 */
            --shadow-light: rgba(0,0,0,0.05); /* Shadow lebih ringan */
            --shadow-medium: rgba(0,0,0,0.1); /* Shadow sedang */
            --transition-speed: 0.3s;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg-color);
            color: var(--text-color); /* Terapkan warna teks default */
            /* padding-top: 85px; */
        }
        .fw-medium { font-weight: 500 !important; }
        .fw-semibold { font-weight: 600 !important; }
        .fw-bold { font-weight: 700 !important; }
        .text-primary { color: var(--primary-color) !important; }

        /* --- Navbar Styling --- */
        .navbar {
            background-color: var(--white-color);
            box-shadow: 0 4px 12px var(--shadow-light);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 0; /* Ini memberikan tinggi pada navbar */
            z-index: 1030; /* Pastikan ini ada dan tinggi */
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem; /* Jarak antara ikon dan teks */
            font-weight: 700;
            font-size: 1.6rem; /* Ukuran font logo */
            color: var(--primary-dark-color) !important; /* Warna logo */
            letter-spacing: 0.5px; /* Sedikit spasi antar huruf */
            transition: color var(--transition-speed) ease;
        }
        .navbar-brand:hover {
            color: var(--primary-color) !important;
        }
        .navbar-brand i {
            font-size: 1.25rem; /* Ukuran ikon di logo */
        }
        .navbar-toggler {
            border-color: var(--border-color); /* Warna border toggler */
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2816, 185, 129, 0.7%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-nav .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 500;
            padding: 0.75rem 1rem; /* Padding yang lebih baik untuk link */
            transition: all var(--transition-speed) ease;
            position: relative; /* Untuk efek underline */
        }
        .navbar-nav .nav-link::after { /* Efek underline dinamis */
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 3px;
            background-color: var(--primary-color);
            transition: all var(--transition-speed) ease;
            transform: translateX(-50%);
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: calc(100% - 2rem); /* Lebar underline sesuai padding */
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Dropdown Styling untuk Navbar */
        .navbar-nav .nav-link.dropdown-toggle {
            padding-right: 1.5rem; /* Pastikan ada ruang untuk arrow dropdown */
        }
        .navbar-nav .nav-link.dropdown-toggle::after {
            vertical-align: 0.15em; /* Posisi arrow dropdown */
        }
        .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: 0 5px 15px var(--shadow-medium);
            border-radius: 0.75rem; /* Sudut membulat */
            padding: 0.5rem 0;
            min-width: 12rem; /* Lebar minimum dropdown */
        }
        .dropdown-item {
            padding: 0.75rem 1.25rem;
            color: var(--secondary-color); /* Teks default item dropdown */
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            /* Perbaikan hover state di sini */
            background-color: transparent; /* Pastikan background default transparan */
        }
        .dropdown-item:hover,
        .dropdown-item:focus { /* Termasuk focus untuk aksesibilitas */
            background-color: var(--light-bg-color); /* Warna hover yang lembut */
            color: var(--primary-color) !important; /* Teks berubah menjadi warna primary */
        }
        .dropdown-item.text-danger:hover { /* Override untuk tombol keluar (merah) */
            background-color: #FEE2E2 !important; /* Red-100 */
            color: #EF4444 !important; /* Red-500 */
        }
        .dropdown-divider {
            margin: 0.5rem 0;
            border-top-color: var(--border-color);
        }
        .dropdown-header {
            font-size: 0.9rem;
            color: var(--secondary-color); /* Warna header dropdown */
            padding: 0.75rem 1.25rem; /* Padding agar konsisten dengan item */
            font-weight: 600; /* Lebih tebal */
        }

        /* Styling untuk Avatar di Navbar (sudah dipindahkan dan disempurnakan) */
        .navbar-avatar {
            width: 38px; /* Ukuran avatar di navbar */
            height: 38px;
            object-fit: cover;
            border: 1.5px solid var(--primary-color); /* Border kecil berwarna primary */
            box-shadow: 0 2px 8px var(--shadow-light);
            transition: all var(--transition-speed) ease;
        }
        .navbar-avatar:hover {
            border-color: var(--primary-dark-color);
            transform: scale(1.05);
        }

        /* Styling untuk nav-link aktif/hover (sudah disempurnakan) */
        /* Sudah di atas, dihapus duplikasi */

        /* Untuk badge keranjang */
        .cart-badge {
            font-size: 0.65rem; /* Ukuran lebih kecil */
            padding: 0.25em 0.5em; /* Padding kecil */
            transform: translate(-10%, -10%); /* Posisikan lebih baik */
        }

        /* Penyesuaian tombol di guest nav */
        .navbar-nav .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        .navbar-nav .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        /* --- Button Styling --- */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
            padding: 0.75rem 1.5rem; /* Padding tombol yang konsisten */
            border-radius: 0.5rem; /* Sudut tombol */
        }
        .btn-primary:hover {
            background-color: var(--primary-dark-color);
            border-color: var(--primary-dark-color);
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(16, 185, 129, 0.3);
        }
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }
        .btn-outline-secondary { /* Menambahkan gaya untuk btn-outline-secondary */
            color: var(--secondary-color);
            border-color: var(--border-color);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
        }
        .btn-outline-secondary:hover {
            background-color: var(--border-color);
            color: var(--secondary-color);
        }

        /* --- Card Styling --- */
        .card {
            border: 1px solid var(--border-color);
            transition: all var(--transition-speed) ease-in-out;
            background-color: var(--white-color);
            border-radius: 0.75rem; /* Sudut card yang lebih membulat */
            overflow: hidden; /* Pastikan konten tidak keluar dari sudut */
        }
        .card:hover {
            box-shadow: 0 10px 30px var(--shadow-medium) !important;
            transform: translateY(-5px);
        }

        /* --- Footer Styling --- */
        footer {
            background-color: var(--secondary-color);
            color: #CBD5E1; /* Warna teks di footer */
            padding: 50px 0 20px;
        }
        footer a {
            color: #CBD5E1;
            text-decoration: none;
            transition: color var(--transition-speed);
        }
        footer a:hover {
            color: var(--primary-color);
        }
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1); /* Border lebih terang */
            padding-top: 20px;
            margin-top: 30px;
            color: #E2E8F0; /* Warna teks copyright */
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 767.98px) {
            .footer .text-md-start { text-align: center !important; }
            .navbar-nav { /* Untuk tampilan mobile */
                text-align: center;
                margin-top: 1rem;
                padding-bottom: 1rem;
                border-top: 1px solid var(--border-color);
            }
            .navbar-nav .nav-item {
                margin: 0.5rem 0;
            }
            .navbar-nav .nav-link::after { /* Matikan efek underline dinamis di mobile */
                width: 0 !important;
            }
            .navbar-nav .nav-link:hover::after,
            .navbar-nav .nav-link.active::after {
                width: 0 !important;
            }
            .d-md-flex { /* Untuk tombol di footer */
                justify-content: center !important;
            }
        }
        
        /* --- SweetAlert Custom Styling --- */
        .swal-modal {
            border-radius: 1rem; /* Sudut lebih membulat */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* Bayangan lebih halus */
            background-color: var(--white-color); /* Pastikan background putih */
        }

        .swal-icon--success:before,
        .swal-icon--success:after,
        .swal-icon--success__hide-corners {
            background: var(--white-color) !important; /* Membuat tick icon lebih bersih */
        }

        .swal-icon--success {
            border-color: var(--primary-color) !important; /* Border hijau */
        }
        .swal-icon--success__line {
            background-color: var(--primary-color) !important; /* Warna tick hijau */
        }

        .swal-icon--error {
            border-color: #EF4444 !important; /* Warna border error merah */
        }
        .swal-icon--error__x-mark {
            fill: #EF4444 !important; /* Warna X merah */
        }
        .swal-icon--error__line {
            background-color: #EF4444 !important; /* Warna garis X merah */
        }
        .swal-icon--warning { /* Styling untuk warning icon */
            border-color: #FBBF24 !important; /* Kuning-400 */
        }
        .swal-icon--warning__body,
        .swal-icon--warning__dot {
            background-color: #FBBF24 !important;
        }

        .swal-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--secondary-color); /* Warna judul */
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .swal-text {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color); /* Warna teks isi */
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            text-align: center; /* Pastikan teks di tengah */
        }

        .swal-button-container {
            display: flex; /* Menggunakan flexbox untuk tombol */
            justify-content: center; /* Posisi tombol di tengah */
            gap: 1rem; /* Jarak antar tombol */
            margin-top: 1rem;
        }

        .swal-button {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            border-radius: 0.5rem; /* Sudut tombol */
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            box-shadow: none !important; /* Hapus shadow default SweetAlert */
            min-width: 100px; /* Lebar minimum tombol */
        }

        .swal-button--confirm {
            background-color: var(--primary-color) !important; /* Warna tombol konfirmasi */
            color: var(--white-color) !important;
            order: 2; /* Menempatkan tombol confirm di kanan */
        }

        .swal-button--confirm:hover {
            background-color: var(--primary-dark-color) !important; /* Warna hover tombol */
            transform: translateY(-1px);
        }

        .swal-button--cancel { /* Gaya untuk tombol batal/coba lagi */
            background-color: var(--border-color) !important;
            color: var(--secondary-color) !important;
            order: 1; /* Menempatkan tombol cancel di kiri */
        }

        .swal-button--cancel:hover {
            background-color: #CBD5E1 !important;
        }
        /* Override untuk tombol danger di SweetAlert (misal Hapus) */
        .swal-button--danger {
            background-color: #EF4444 !important; /* Merah */
            color: var(--white-color) !important;
        }
        .swal-button--danger:hover {
            background-color: #DC2626 !important; /* Merah lebih gelap */
        }

        /* Jika Anda ingin sedikit lebih kompak di mobile */
        @media (max-width: 576px) {
            .swal-modal {
                margin: 1rem; /* Sedikit margin agar tidak terlalu mepet */
            }
            .swal-button {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            .swal-button-container {
                flex-direction: column; /* Tombol vertikal di mobile */
                gap: 0.5rem;
            }
            .swal-button--confirm, .swal-button--cancel {
                width: 100%; /* Tombol full width di mobile */
                order: unset !important; /* Hapus order di mobile */
            }
        }
        /* Styling untuk Detail Produk */
        .product-image-wrapper {
            height: 400px; /* Tinggi tetap untuk gambar */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-main-image {
            object-fit: cover; /* Pastikan gambar mengisi ruang dengan baik */
            height: 100%;
            width: 100%;
        }
        .product-no-image {
            height: 100%; /* Memastikan placeholder juga mengisi ruang */
        }

        /* Styling untuk Nav-Pills di Detail Produk */
        .product-tabs .nav-link {
            color: var(--secondary-color);
            background-color: transparent;
            border: none;
            border-radius: 0.5rem 0.5rem 0 0; /* Sudut atas membulat, bawah datar */
            padding: 0.75rem 1.25rem;
            position: relative;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
        }
        .product-tabs .nav-link.active {
            color: var(--primary-color) !important;
            background-color: var(--white-color) !important;
            border-bottom: 3px solid var(--primary-color) !important; /* Underline tebal saat aktif */
            z-index: 1; /* Agar terlihat di atas konten */
        }
        .product-tabs .nav-link:hover:not(.active) {
            color: var(--primary-dark-color);
            background-color: var(--light-bg-color);
        }
        .product-tabs {
            border-bottom: 1px solid var(--border-color); /* Garis bawah untuk tab keseluruhan */
        }

        /* Avatar Lingkaran untuk Ulasan */
        .avatar-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 1.2rem;
            background-color: var(--primary-color); /* Warna background avatar */
            color: var(--white-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0; /* Pastikan tidak mengecil */
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        /* Input Quantity */
        .quantity-input {
            border-left: none;
            border-right: none;
            background-color: var(--white-color);
            color: var(--secondary-color);
        }
        .input-group .btn-outline-secondary {
            border-radius: 0.5rem !important; /* Membulatkan sudut tombol + - */
            border-color: var(--border-color);
            color: var(--secondary-color);
            width: 40px; /* Lebar tombol + - */
        }
        .input-group .btn-outline-secondary:first-child {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        .input-group .btn-outline-secondary:last-child {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        /* Memperbaiki border-radius untuk input di tengah input-group */
        .input-group > .form-control {
            border-radius: 0 !important;
        }
        .input-group:focus-within .form-control,
        .input-group:focus-within .btn-outline-secondary {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
        }
        /* Styling untuk tombol aksi di tabel (produk/index.blade.php untuk penjual) */
        .table .btn-outline-secondary,
        .table .btn-outline-primary,
        .table .btn-outline-danger {
            border-width: 1.5px; /* Sedikit lebih tebal */
            padding: 0.4rem 0.6rem; /* Ukuran lebih kecil untuk sm */
            font-size: 0.85rem; /* Ukuran font ikon/teks lebih kecil */
        }

        /* Default state */
        .table .btn-outline-secondary {
            color: var(--secondary-color);
            border-color: var(--border-color); /* Warna border yang terlihat */
        }
        .table .btn-outline-secondary:hover {
            background-color: var(--border-color);
            color: var(--secondary-color);
        }

        .table .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .table .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        .table .btn-outline-danger {
            color: #EF4444; /* Red-500 */
            border-color: #EF4444;
        }
        .table .btn-outline-danger:hover {
            background-color: #EF4444;
            color: var(--white-color);
        }

        /* Pastikan ikon di dalam tombol juga memiliki warna yang benar */
        .table .btn-outline-secondary i,
        .table .btn-outline-primary i,
        .table .btn-outline-danger i {
            color: inherit; /* Menerapkan warna teks tombol ke ikon */
        }
        /* Custom CSS untuk halaman produk/index.blade.php */
        /* Thumbnail produk di tabel (untuk penjual) */
        .product-thumb-sm {
            width: 60px;
            height: 60px;
            object-fit: cover;
            flex-shrink: 0; /* Pastikan tidak mengecil */
        }
        .product-thumb-sm i {
            font-size: 1.25rem;
        }

        /* Thumbnail produk di card mobile (untuk penjual) */
        .product-thumb-mobile {
            height: 90px; /* Tinggi tetap untuk thumbnail mobile */
            object-fit: cover;
        }
        .product-thumb-mobile-placeholder {
            height: 90px; /* Placeholder juga harus punya tinggi */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Card produk di grid (untuk pembeli/tamu) */
        .product-grid-image {
            height: 200px; /* Tinggi tetap untuk gambar produk di grid */
            object-fit: cover;
        }
        .product-grid-image-placeholder {
            height: 200px; /* Placeholder juga harus punya tinggi */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-title-grid {
            min-height: 48px; /* Memberikan tinggi min agar judul 2 baris tidak merusak layout */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Efek hover untuk card produk pembeli/tamu */
        .product-card-hover {
            transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        }
        .product-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px var(--shadow-medium) !important;
        }
        /* Styling khusus untuk halaman Edit Profil */
        .profile-avatar {
            border: 3px solid var(--border-color); /* Border ringan di sekitar avatar */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .upload-button-avatar {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: var(--white-color) !important;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
        }
        .upload-button-avatar:hover {
            background-color: var(--primary-dark-color) !important;
            border-color: var(--primary-dark-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        /* Form control size adjustments */
        .form-control-lg {
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            border-radius: 0.5rem; /* Sudut membulat */
            border: 1px solid var(--border-color);
        }
        .form-control-lg:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }
        /* Styling khusus untuk halaman Profil Saya (show.blade.php) */
        .profile-avatar-lg {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border: 4px solid var(--white-color); /* Border putih di sekitar avatar */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Shadow lebih kuat */
        }

        .profile-details-list .list-group-item {
            border-bottom: 1px solid var(--border-color); /* Garis pemisah antar item */
        }
        .profile-details-list .list-group-item:last-child {
            border-bottom: none; /* Hapus border bawah pada item terakhir */
        }

        /* Responsive adjustment for product grid title */
        @media (max-width: 575.98px) {
            .product-title-grid {
                min-height: unset; /* Matikan min-height di mobile jika diperlukan */
                font-size: 0.95rem !important; /* Ukuran font lebih kecil di mobile */
            }
            .product-grid-image, .product-grid-image-placeholder {
                height: 150px; /* Kurangi tinggi gambar di mobile */
            }
        }
    </style>
    @stack('css')
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fa fa-store"></i>
            <span>BANGKIT</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @include('layout.partials._navbar_items')
            </ul>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

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
                    {{-- Tambahkan link navigasi lainnya di sini jika ada --}}
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

{{-- SCRIPT SWEETALERT UNTUK NOTIFIKASI --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    // Cek jika ada pesan sukses dari session
    @if(session('success'))
        swal({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            button: "Luar Biasa!", // Mengubah teks button untuk sukses
        });
    @endif

    // Cek jika ada error validasi (berguna untuk halaman form)
    @if ($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += "- {{ $error }}\n"; // Menambahkan bullet point
        @endforeach

        swal({
            title: "Oops, Gagal!",
            text: errorMessages,
            icon: "error",
            button: "Coba Lagi",
        });
    @endif
</script>

<script>
    // Menangkap event submit pada semua form dengan class 'delete-form'
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form langsung dikirim

            swal({
                title: "Apakah Anda Yakin?",
                text: "Data produk yang sudah dihapus tidak dapat dikembalikan lagi!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Batal", // Teks untuk tombol batal
                        value: null, // Penting agar SweetAlert tidak menganggapnya sebagai confirm
                        visible: true,
                        className: "swal-button swal-button--cancel", // Gunakan kelas kustom
                    },
                    confirm: {
                        text: "Ya, Hapus Saja!",
                        value: true,
                        visible: true,
                        className: "swal-button swal-button--danger", // Gunakan kelas kustom danger
                    }
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                // Jika pengguna menekan tombol "Ya, Hapus Saja!"
                if (willDelete) {
                    // Lanjutkan proses submit form
                    this.submit();
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')
</body>
</html>