@guest
    <li class="nav-item mb-2 mb-lg-0">
        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill w-100">Masuk</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill w-100">Daftar</a>
    </li>
@else
    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
    <li class="nav-item"><a href="{{ route('produk.index') }}" class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}">Produk</a></li>
    @if(Auth::user()->role == 'pembeli')
        <li class="nav-item"><a href="{{ route('transaksi.index') }}" class="nav-link">Transaksi</a></li>
        <li class="nav-item position-relative"><a class="nav-link" href="{{ route('keranjang.index') }}">Keranjang
            @php $keranjangCount = \App\Models\Keranjang::where('user_id', Auth::id())->count(); @endphp
            @if($keranjangCount > 0)<span class="badge bg-danger ms-1">{{ $keranjangCount }}</span>@endif
        </a></li>
    @endif
    @if(Auth::user()->role == 'admin')
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Panel</a></li>
    @elseif(Auth::user()->role == 'penjual')
         <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard Penjual</a></li>
    @endif
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ Auth::user()->foto_profil ? asset('foto_profil/'.Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama).'&background=475569&color=fff&size=32' }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
            {{ Str::limit(Auth::user()->nama, 10) }}
        </a>
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