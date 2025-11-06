@extends('layout.admin')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <h6 class="mb-2 dark:text-white">Informasi Akun Admin</h6>
            </div>
            <div class="flex-auto p-4">
                {{-- Tampilkan pesan sukses jika ada --}}
                @if (session('success'))
                    <div class="px-4 py-3 mb-4 text-white bg-green-500 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-bold text-slate-700 dark:text-white/80">Nama</label>
                    <p class="text-sm dark:text-white">{{ $admin->nama }}</p>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-bold text-slate-700 dark:text-white/80">Email</label>
                    <p class="text-sm dark:text-white">{{ $admin->email }}</p>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-bold text-slate-700 dark:text-white/80">Role</label>
                    <p class="text-sm dark:text-white capitalize">{{ $admin->role }}</p>
                </div>

                {{-- Tambahkan tombol Edit jika Anda sudah membuat fitur edit --}}
                {{-- <div class="text-right mt-6">
                    <a href="{{ route('admin.profil.edit') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem shadow-md hover:shadow-lg">
                        Edit Profil
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
