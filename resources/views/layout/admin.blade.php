<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fc;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .nav-link.active {
            background-color: #1abc9c;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
        }
        .content-wrapper {
            min-height: 100vh;
            padding: 20px;
            background-color: #f8f9fc;
        }
        .sidebar .nav-link i {
            width: 20px;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="sidebar p-3" id="sidebar-wrapper">
        <h4 class="text-center fw-bold mb-4">
            <i class="fa fa-user-shield me-2"></i>ADMIN
        </h4>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fa fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('produk.index') }}" class="nav-link {{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="fa fa-box-open"></i> Kelola Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->is('pesanan*') ? 'active' : '' }}">
                    <i class="fa fa-inbox"></i> Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="fa fa-users"></i> Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="fa fa-sign-out-alt"></i> Keluar
                </a>
            </li>
        </ul>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="flex-grow-1">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light shadow-sm px-4">
            <div class="container-fluid">
                <span class="navbar-brand fw-bold">Marketplace BANGKIT Admin</span>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link text-muted">
                            <i class="fa fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </span>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="content-wrapper">
            <div class="container-fluid">
                <h4 class="mb-4">@yield('title')</h4>
                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
