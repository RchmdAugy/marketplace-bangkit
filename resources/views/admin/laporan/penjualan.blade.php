@extends('layout.admin')

@section('title', 'Laporan Penjualan')
@section('page_title', 'Laporan Penjualan')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <h6 class="mb-2 dark:text-white">Laporan Penjualan per Penjual (Transaksi Diproses, Dikirim, Selesai)</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Penjual</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jumlah Transaksi Berhasil</th>
                            <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total Pendapatan</th>
                            {{-- KOLOM BARU --}}
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $data)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $data->nama_penjual }}</h6>
                                        {{-- Tambahkan email jika perlu --}}
                                        {{-- <p class="mb-0 text-xs leading-tight dark:text-white/80 text-slate-400">{{ $data->email_penjual ?? '' }}</p> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="mb-0 text-sm font-semibold leading-tight dark:text-white">{{ $data->jumlah_transaksi }}</p>
                            </td>
                            <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <p class="mb-0 text-sm font-semibold leading-tight dark:text-white">Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}</p>
                            </td>
                            {{-- TOMBOL BARU --}}
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <a href="{{ route('admin.laporan.penjualan.detail', $data->user_id) }}" class="inline-block px-4 py-2 text-xs font-bold text-center text-blue-500 uppercase align-middle transition-all border border-blue-500 border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out bg-transparent hover:scale-102 active:shadow-xs tracking-tight-rem hover:bg-blue-500 hover:text-white hover:opacity-75">
                                    Detail Produk
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                             {{-- Ubah colspan jadi 4 --}}
                            <td colspan="4" class="p-4 text-center text-sm text-slate-500">Tidak ada data penjualan yang selesai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
