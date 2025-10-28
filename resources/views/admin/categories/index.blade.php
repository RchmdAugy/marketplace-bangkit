@extends('layout.admin')

@section('title', 'Kelola Kategori')
@section('page_title', 'Kelola Kategori Produk')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between">
                    <h6 class="mb-2 dark:text-white">Daftar Kategori Produk</h6>
                    <a href="{{ route('admin.categories.create') }}" class="inline-block px-4 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem border-blue-500 text-blue-500 hover:opacity-75">
                        <i class="fa fa-plus"></i> Tambah Kategori
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                @if (session('success'))
                    <div class="px-4 py-2 mx-4 my-2 text-white bg-green-500 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- Menampilkan error jika ada (misal gagal hapus) --}}
                 @if($errors->any())
                    <div class="px-4 py-2 mx-4 my-2 text-white bg-red-500 rounded-lg">
                        {{ $errors->first() }}
                    </div>
                @endif

                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Kategori</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Slug (untuk URL)</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <h6 class="px-4 mb-0 text-sm leading-normal dark:text-white">{{ $category->name }}</h6>
                            </td>
                             <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="px-4 mb-0 text-sm leading-normal dark:text-white/80 text-slate-400">{{ $category->slug }}</p>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-xs font-semibold leading-tight dark:text-white text-slate-400"> Edit </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Menghapus kategori mungkin akan membuat produk terkait menjadi tidak berkategori.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-xs font-semibold leading-tight text-red-500"> Hapus </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-sm text-slate-500">Tidak ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection