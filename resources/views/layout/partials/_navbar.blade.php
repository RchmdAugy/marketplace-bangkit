{{-- 
    PERUBAHAN:
    1. navbar-scroll="false" -> navbar-scroll="true" (agar JS tema mau menambah background saat scroll)
    2. Menambahkan class "sticky top-0 z-10 shadow-md backdrop-blur-sm"
    3. Mengubah href link profil ke route('admin.profil.show') 
--}}
<nav class="sticky top-0 z-10 shadow-md backdrop-blur-sm relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            {{-- Breadcrumb --}}
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="text-sm leading-normal"><a class="opacity-50 dark:text-white text-slate-700" href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="text-sm pl-2 capitalize leading-normal dark:text-white text-slate-700 before:float-left before:pr-2 dark:before:text-white before:text-gray-600 before:content-['/']" aria-current="page">
                    @yield('page_title', 'Dashboard')
                </li>
            </ol>
            <h6 class="mb-0 font-bold capitalize dark:text-white">@yield('page_title', 'Dashboard')</h6>
        </nav>

        {{-- Navbar Right Side --}}
        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
                {{-- Anda bisa tambahkan search bar di sini jika perlu --}}
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                {{-- User Info & Link Profil --}}
                <li class="flex items-center">
                    <a href="{{ route('admin.profil.show') }}" class="block px-0 py-2 text-sm font-semibold transition-all ease-nav-brand dark:text-white text-slate-700">
                        <i class="fa fa-user sm:mr-1"></i>
                        <span class="hidden sm:inline">{{ Auth::user()->nama }}</span>
                    </a>
                </li>
                
                {{-- Hamburger Menu (Mobile) --}}
                <li class="flex items-center pl-4 xl:hidden">
                    <a href="javascript:;" class="block p-0 text-sm transition-all ease-nav-brand dark:text-white text-slate-700" sidenav-trigger>
                        <div class="w-4.5 overflow-hidden">
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-slate-700 dark:bg-white transition-all"></i>
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-slate-700 dark:bg-white transition-all"></i>
                            <i class="ease relative block h-0.5 rounded-sm bg-slate-700 dark:bg-white transition-all"></i>
                        </div>
                    </a>
                </li>
                
                {{-- Anda bisa tambahkan icon notifikasi/setting di sini --}}

            </ul>
        </div>
    </div>
</nav>

