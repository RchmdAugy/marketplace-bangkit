@extends('layout.admin')

@section('title', 'Detail Laporan Produk - ' . $penjual->nama)
@section('page_title', 'Detail Laporan Produk')

@push('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                 <div class="flex justify-between items-center mb-2">
                    <h6 class="mb-0 dark:text-white">Ranking Produk Terlaris untuk Akun: <span class="font-bold text-blue-500">{{ $penjual->nama }}</span></h6>
                    <a href="{{ route('admin.laporan.penjualan') }}" class="inline-block px-4 py-2 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem border-slate-700 text-slate-700 hover:opacity-75">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <p class="text-sm text-slate-500">(Berdasarkan Jumlah Unit Terjual dari Transaksi Diproses, Dikirim, Selesai)</p>
            </div>
            <div class="overflow-x-auto p-4">
                <table class="items-center w-full mb-0 align-top border-collapse border-gray-200 dark:border-white/40">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 dark:text-white/70">Rank</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 dark:text-white/70">Nama Produk</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 dark:text-white/70">Nama UMKM</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 dark:text-white/70">Jumlah Terjual</th>
                            <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 dark:text-white/70">Total Pendapatan Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanProduk as $index => $produk)
                        <tr>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <span class="text-sm font-semibold leading-tight dark:text-white">{{ $index + 1 }}</span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $produk->nama_produk }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="mb-0 text-sm leading-tight dark:text-white/80 text-slate-500">{{ $produk->nama_umkm ?? '-' }}</p>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="mb-0 text-sm font-semibold leading-tight dark:text-white">{{ $produk->total_terjual }}</p>
                            </td>
                            <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="mb-0 text-sm font-semibold leading-tight dark:text-white">Rp {{ number_format($produk->total_pendapatan_produk, 0, ',', '.') }}</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-sm text-slate-500 dark:text-white/60">Akun ini belum memiliki produk yang terjual.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection