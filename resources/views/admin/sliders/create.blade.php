@extends('layout.admin')

@section('title', 'Tambah Slider Baru')
@section('page_title', 'Tambah Slider')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <h6 class="mb-2 dark:text-white">Formulir Slider Baru</h6>
            </div>
            <div class="flex-auto p-4">
                @if ($errors->any())
                    <div class="text-white px-6 py-4 border-0 rounded-lg relative mb-4 bg-red-500">
                        <span class="inline-block align-middle mr-8">Terdapat kesalahan pada input Anda:</span>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Judul</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <div class="mb-4">
                        <label for="subtitle" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Subjudul</label>
                        <textarea id="subtitle" name="subtitle" rows="3" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>{{ old('subtitle') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Gambar (Rasio 16:9 disarankan)</label>
                        <input type="file" id="image" name="image" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent " />
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
                            <label for="button_text" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Teks Tombol (Opsional)</label>
                            {{-- Menghapus 'required' --}}
                            <input type="text" id="button_text" name="button_text" value="{{ old('button_text', 'Lihat Koleksi') }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                        </div>
                        <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                             <label for="order" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Urutan Tampil</label>
                            <input type="number" id="order" name="order" value="{{ old('order', 0) }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                        </div>
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="button_link" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">URL Link Tombol (Opsional)</label>
                        {{-- Menghapus 'required' --}}
                        <input type="url" id="button_link" name="button_link" value="{{ old('button_link', route('produk.index')) }}" placeholder="Contoh: https://www.tokopedia.com/..." class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" checked>
                            <label for="is_active" class="ml-2 text-sm font-bold text-slate-700 dark:text-white/80">Aktifkan slider ini?</label>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('admin.sliders.index') }}" class="inline-block px-4 py-2 mr-2 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem border-slate-700 text-slate-700 hover:opacity-75">Batal</a>
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem shadow-md hover:shadow-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection