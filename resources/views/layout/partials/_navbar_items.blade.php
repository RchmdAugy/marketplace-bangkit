{{-- resources/views/layout/partials/_navbar_items.blade.php --}}

@guest
    {{-- Tombol Login/Daftar untuk Guest --}}
    <li class="nav-item me-lg-2 mb-2 mb-lg-0">
        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">Masuk</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">Daftar</a>
    </li>
@else
    {{-- Item Navigasi Umum (untuk semua user yang login) --}}
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i>Beranda
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('produk.index') }}" class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}">
            <i class="fa fa-boxes me-2"></i>Produk
        </a>
    </li>
    
    {{-- Navigasi Khusus Pembeli --}}
    @if(Auth::user()->role == 'pembeli')
        <li class="nav-item">
            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                <i class="fa fa-receipt me-2"></i>Transaksi
            </a>
        </li>
        <li class="nav-item position-relative">
            <a class="nav-link {{ request()->routeIs('keranjang.index') ? 'active' : '' }}" href="{{ route('keranjang.index') }}">
                <i class="fa fa-shopping-cart"></i>
                @php $keranjangCount = \App\Models\Keranjang::where('user_id', Auth::id())->count(); @endphp
                @if($keranjangCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">{{ $keranjangCount }}</span>
                @endif
            </a>
        </li>
    @endif

    {{-- Navigasi Khusus Admin --}}
    @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-cogs me-2"></i>Admin Panel
            </a>
        </li>
    @endif
    
    {{-- Navigasi Khusus Penjual --}}
    @if(Auth::user()->role == 'penjual')
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line me-2"></i>Dashboard Penjual
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->routeIs('pesanan.index') ? 'active' : '' }}">
                <i class="fa fa-clipboard-list me-2"></i>Pesanan Masuk
            </a>
        </li>
    @endif

    {{-- DROPDOWN PROFIL (untuk semua user yang login) --}}
    <li class="nav-item dropdown ms-lg-3"> {{-- Tambahkan margin-left di desktop untuk jarak --}}
        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{-- Menggunakan ui-avatars atau foto_profil. Sesuaikan 'foto_profil/' dengan path storage Anda. --}}
            <img src="{{ Auth::user()->foto_profil ? asset('foto_profil/'.Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama).'&background=10B981&color=fff&size=38' }}" 
                 alt="Avatar" 
                 class="rounded-circle me-2 navbar-avatar">
            {{-- Nama pengguna (hanya tampil di desktop, ringkas di mobile) --}}
            <span class="d-none d-lg-inline fw-semibold text-secondary">{{ Str::limit(Auth::user()->nama, 12) }}</span> 
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="navbarDropdown">
            <li><h6 class="dropdown-header text-uppercase">
                @if(Auth::user()->role == 'penjual' && Auth::user()->nama_toko)
                    {{ Str::limit(Auth::user()->nama_toko, 20) }} {{-- Tampilkan nama toko untuk penjual --}}
                @else
                    {{ Str::limit(Auth::user()->nama, 20) }} {{-- Nama personal untuk pembeli/admin --}}
                @endif
            </h6></li>
            <li><hr class="dropdown-divider"></li>
            
            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profil.show') }}"><i class="fa fa-user-circle fa-fw me-2"></i> Profil Saya</a></li>
            
            {{-- Item tambahan di dropdown, hanya jika relevan dan tidak duplikat --}}
            @if(Auth::user()->role == 'pembeli')
                <!-- <li><a class="dropdown-item d-flex align-items-center" href="{{ route('transaksi.index') }}"><i class="fa fa-receipt fa-fw me-2"></i> Riwayat Transaksi</a></li> -->
            @endif
            {{-- Item Manajemen Produk (untuk penjual) dihapus dari sini karena sudah ada di navigasi utama --}}
            @if(Auth::user()->role == 'admin')
                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}"><i class="fa fa-cogs fa-fw me-2"></i> Admin Panel</a></li>
            @endif

            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                        <i class="fa fa-sign-out-alt fa-fw me-2"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </li>
@endauth