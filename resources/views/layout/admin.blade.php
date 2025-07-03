<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <link href="{{ asset('admin_assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />

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
    
    <script src="{{ asset('admin_assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
    <script src="{{ asset('admin_assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>

    @stack('scripts')
</body>
</html>