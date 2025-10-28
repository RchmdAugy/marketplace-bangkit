<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Marketplace BANGKIT - @yield('title')</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0844a0ff;
        }
        .sidebar {
            background-color: #1abc9c;
            min-height: 100vh;
            padding-top: 1rem;
            width: 200px;
        }
        .sidebar h4 {
            color: white;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #16a085;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }

        .btn-primary { background-color: #1abc9c; border: none; }
        .btn-primary:hover { background-color: #16a085; }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 20px;
        }

        table th, table td { vertical-align: middle !important; }
        table tbody tr:hover { background-color: #f1f1f1; }
        .table-dark { background-color: #16a085; color: white; }
    </style>
</head>

<body>

<div class="d-flex">
    <div class="sidebar position-fixed">
        <h4 class="text-center">BANGKIT</h4>
        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Beranda</a>
        <a href="{{ route('produk.index') }}"><i class="fa fa-box"></i> Produk</a>
        <a href="{{ route('transaksi.index') }}"><i class="fa fa-shopping-cart"></i> Transaksi</a>

        @if(Auth::check())
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'penjual')
                <a href="{{ route('pesanan.index') }}"><i class="fa fa-truck"></i> Pesanan Masuk</a>
                <a href="{{ route('dashboard') }}"><i class="fa fa-chart-bar"></i> Dashboard</a>
            @endif
            <a href="{{ route('logout') }}"><i class="fa fa-sign-out-alt"></i> Keluar</a>
        @else
            <a href="{{ route('login') }}"><i class="fa fa-sign-in-alt"></i> Masuk</a>
            <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Daftar</a>
        @endif
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
