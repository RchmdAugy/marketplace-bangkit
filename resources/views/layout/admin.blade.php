<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - @yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    {{-- Tailwind CSS Assets --}}
    <link href="{{ asset('admin_assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    {{-- Ini adalah main Tailwind CSS Anda --}}
    <link href="{{ asset('admin_assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
    
    {{-- Custom CSS untuk Admin Panel (jika ada) --}}
    <style>
        /* Anda bisa menambahkan custom styling Tailwind di sini jika diperlukan */
        .min-h-75 {
            min-height: 75px; /* Tetap pertahankan jika ini yang Anda inginkan */
        }
        /* Overrides atau tambahan untuk sidebar/navbar jika default Tailwind kurang sesuai */
        .sidebar-brand-text {
            color: #334155; /* Warna teks logo sidebar */
            font-weight: 700;
        }
        .sidebar-link.active .sidebar-icon,
        .sidebar-link.active .sidebar-text {
            color: #ffffff !important; /* Warna ikon & teks aktif */
        }
        .sidebar-link.active {
            background-color: #3B82F6; /* Warna background item sidebar aktif */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Shadow untuk item aktif */
        }
        .sidebar-link {
            transition: all 0.2s ease-in-out; /* Transisi untuk hover dan active */
        }
        .sidebar-link:hover {
            background-color: rgba(59, 130, 246, 0.1); /* Warna hover yang lebih lembut */
        }
        .sidebar-link.active:hover { /* Jaga warna aktif saat di hover */
            background-color: #3B82F6;
        }

        /* Untuk teks di dalam sidebar yang dikategorikan */
        .sidebar-category-title {
            color: #64748B; /* Slate-500 */
        }
    </style>

    {{-- Tailwind CSS Config (opsional, jika Anda meng-override default) --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">

    <div class="absolute w-full bg-blue-500 min-h-75"></div>

    {{-- Memanggil Sidebar Admin --}}
    @include('layout.partials._sidebar')

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">

        {{-- Memanggil Navbar Admin --}}
        @include('layout.partials._navbar')

        <div class="w-full px-6 py-6 mx-auto">
            @yield('content')

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

    {{-- Core plugin JavaScript --}}
    <script src="{{ asset('admin_assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
    <script src="{{ asset('admin_assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>

    @stack('scripts')
</body>
</html>