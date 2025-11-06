<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    {{-- Tailwind CSS Assets --}}
    <link href="{{ asset('admin_assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
    
    {{-- Custom CSS untuk Admin Panel --}}
    <style>
        .min-h-75 { min-height: 75px; }
        .sidebar-brand-text { color: #334155; font-weight: 700; }
        .sidebar-link.active .sidebar-icon,
        .sidebar-link.active .sidebar-text { color: #ffffff !important; }
        .sidebar-link.active {
            background-color: #3B82F6; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); 
            border-radius: 0.5rem; /* Tambah rounded corners di item aktif */
        }
        .sidebar-link { transition: all 0.2s ease-in-out; }
        .sidebar-link:hover { background-color: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; }
        .sidebar-link.active:hover { background-color: #3B82F6; }
        .sidebar-category-title { color: #64748B; }

        /* Custom Scrollbar (Webkit browsers like Chrome, Edge, Safari) */
        aside::-webkit-scrollbar { width: 6px; }
        aside::-webkit-scrollbar-track { background: transparent; }
        aside::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,.2); border-radius: 10px; }
        aside:hover::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,.4); }

        /* Navbar Sticky Background saat scroll (dikelola JS tema tapi bisa di-force) */
        nav[navbar-scroll="true"] {
             background-color: rgba(255, 255, 255, 0.8) !important; /* White with opacity */
             backdrop-filter: saturate(200%) blur(30px) !important;
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }
        /* Dark mode for Navbar Sticky */
        .dark nav[navbar-scroll="true"] {
            background-color: rgba(26, 32, 53, 0.8) !important; /* Dark background with opacity */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
{{-- Pastikan ada class dark:bg-slate-900 di body --}}
<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">

    {{-- Background Biru Atas (tidak berubah) --}}
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

    {{-- Memanggil Sidebar Admin --}}
    @include('layout.partials._sidebar')

    {{-- Bagian Konten Utama --}}
    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">

        {{-- Memanggil Navbar Admin --}}
        @include('layout.partials._navbar')

        {{-- =============================================== --}}
        {{-- ==  PERUBAHAN: Tambah pt-16 (padding top)   == --}}
        {{-- =============================================== --}}
        <div class="w-full px-6 py-6 mx-auto pt-16"> {{-- Tambahkan pt-16 atau sesuaikan --}}
            @yield('content')

            {{-- Footer (tidak berubah) --}}
            <footer class="pt-4">
                <div class="w-full px-6 mx-auto">
                    <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
                        <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                            <div class="text-sm leading-normal text-center text-slate-500 lg:text-left">
                                &copy; {{ date('Y') }} Marketplace BANGKIT Admin Panel.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    {{-- Core plugin JavaScript (tidak berubah) --}}
    <script src="{{ asset('admin_assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
    <script src="{{ asset('admin_assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>

    @stack('scripts')
</body>
</html>

