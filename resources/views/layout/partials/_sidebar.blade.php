{{-- resources/views/layout/partials/_sidebar.blade.php --}}

<aside class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false">
    <div class="h-19">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="{{ route('admin.dashboard') }}">
            {{-- Sesuaikan path logo jika berbeda --}}
            <img src="{{ asset('admin_assets/img/logo-ct-dark.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
            <span class="ml-1 sidebar-brand-text">Admin BANGKIT</span> {{-- Class kustom untuk styling --}}
        </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">

            {{-- Dashboard --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal ni ni-tv-2 sidebar-icon {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-500' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Dashboard</span>
                </a>
            </li>

            {{-- Kategori: Manajemen --}}
            <li class="w-full mt-4"><h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60 sidebar-category-title">Manajemen</h6></li>
            
            {{-- Kelola User --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal ni ni-single-02 sidebar-icon {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-700' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Kelola User</span>
                </a>
            </li>

            {{-- Persetujuan Penjual --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.approval') ? 'active' : '' }}" href="{{ route('admin.approval') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal ni ni-check-bold sidebar-icon {{ request()->routeIs('admin.approval') ? 'text-white' : 'text-orange-500' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Persetujuan Penjual</span>
                </a>
            </li>

            {{-- Persetujuan Produk --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.produk.approval') ? 'active' : '' }}" href="{{ route('admin.produk.approval') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal ni ni-box-2 sidebar-icon {{ request()->routeIs('admin.produk.approval') ? 'text-white' : 'text-cyan-500' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Persetujuan Produk</span>
                </a>
            </li>
            
            {{-- =================================== --}}
            {{-- ==  KATEGORI & LINK SLIDER (BARU)  == --}}
            {{-- =================================== --}}
            <li class="w-full mt-4"><h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60 sidebar-category-title">Konten</h6></li>
            
            {{-- Kelola Slider --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        {{-- Menggunakan ikon ni-image dan warna pink --}}
                        <i class="relative top-0 text-sm leading-normal ni ni-image sidebar-icon {{ request()->routeIs('admin.sliders.*') ? 'text-white' : 'text-pink-500' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Kelola Slider</span>
                </a>
            </li>
            {{-- =================================== --}}
            {{-- ==     AKHIR BAGIAN BARU         == --}}
            {{-- =================================== --}}

            {{-- =================================== --}}
            {{-- ==   TAMBAHKAN LINK KATEGORI INI   == --}}
            {{-- =================================== --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        {{-- Menggunakan ikon ni-bullet-list-67 dan warna ungu --}}
                        <i class="relative top-0 text-sm leading-normal ni ni-bullet-list-67 sidebar-icon {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-purple-500' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Kelola Kategori</span>
                </a>
            </li>
            {{-- =================================== --}}

            {{-- Kategori: Laporan --}}
            <li class="w-full mt-4"><h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60 sidebar-category-title">Laporan</h6></li>
            
            {{-- Laporan Penjualan --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('admin.laporan.penjualan') ? 'active' : '' }}" href="{{ route('admin.laporan.penjualan') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal ni ni-chart-bar-32 sidebar-icon {{ request()->routeIs('admin.laporan.penjualan') ? 'text-white' : 'text-emerald-500' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Laporan Penjualan</span>
                </a>
            </li>

            {{-- Kategori: Akun --}}
            <li class="w-full mt-4"><h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60 sidebar-category-title">Akun</h6></li>
            
            {{-- Logout --}}
            <li class="mt-0.5 w-full">
                <a class="sidebar-link py-2.7 my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors" href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal ni ni-button-power sidebar-icon text-red-600"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease sidebar-text">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>