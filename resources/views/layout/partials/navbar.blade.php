<nav class="navbar navbar-expand-lg" style="background-color: #1abc9c;">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ route('home') }}">BANGKIT</a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link text-white">Beranda</a></li>
                <li class="nav-item"><a href="{{ route('produk.index') }}" class="nav-link text-white">Produk</a></li>
                <li class="nav-item"><a href="{{ route('transaksi.index') }}" class="nav-link text-white">Transaksi</a></li>

                @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'penjual')
                        <li class="nav-item"><a href="{{ route('pesanan.index') }}" class="nav-link text-white">Pesanan</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                    @endif
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-white">Keluar</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-white">Masuk</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link text-white">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
