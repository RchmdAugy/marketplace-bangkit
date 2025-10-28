@extends('layout.admin')

@section('title', 'Kelola Slider')
@section('page_title', 'Kelola Slider')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between">
                    <h6 class="mb-2 dark:text-white">Daftar Slider</h6>
                    <a href="{{ route('admin.sliders.create') }}" class="inline-block px-4 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem border-blue-500 text-blue-500 hover:opacity-75">
                        <i class="fa fa-plus"></i> Tambah Slider
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                @if (session('success'))
                    <div class="px-4 py-2 mx-4 my-2 text-white bg-green-500 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="px-4 py-2 mx-4 my-2 text-white bg-red-500 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Urutan</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Gambar</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Judul</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sliders as $slider)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="px-4 mb-0 text-sm font-semibold leading-tight dark:text-white">{{ $slider->order }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <img src="{{ asset('foto_slider/'.$slider->image) }}" alt="{{ $slider->title }}" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-16 rounded-xl">
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <h6 class="px-2 mb-0 text-sm leading-normal dark:text-white">{{ $slider->title }}</h6>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                @if ($slider->is_active)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Aktif</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="text-xs font-semibold leading-tight dark:text-white text-slate-400"> Edit </a>
                                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-xs font-semibold leading-tight text-red-500"> Hapus </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-sm text-slate-500">Tidak ada data slider.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection