@extends('layout.admin')

@section('title', 'Persetujuan Produk')
@section('page_title', 'Persetujuan Produk')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <h6 class="mb-2 dark:text-white">Daftar Produk Menunggu Persetujuan</h6>
            </div>
            <div class="flex-auto p-4">
                @if (session('success'))
                    <div class="px-4 py-3 mb-4 text-white bg-green-500 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if($pendingProduks->count())
                    <div class="overflow-x-auto">
                        <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Produk</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Penjual</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Harga</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingProduks as $produk)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <div class="flex px-2 py-1">
                                            @if($produk->foto)
                                                <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="product" />
                                            @endif
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $produk->nama }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white/80">{{ $produk->user->nama }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <span class="text-xs font-semibold leading-tight dark:text-white/80 text-slate-400">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <form method="POST" action="{{ route('admin.produk.approve', $produk->id) }}">
                                            @csrf
                                            <button type="submit" class="inline-block px-5 py-2.5 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:shadow-xs hover:-translate-y-px active:opacity-85 leading-normal text-xs ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-emerald-500 to-teal-400">
                                                Setujui
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center border-dashed rounded-lg border-2 border-gray-200">
                        <p class="text-sm text-slate-500">Tidak ada produk yang menunggu persetujuan saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection