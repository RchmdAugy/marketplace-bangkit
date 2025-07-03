@extends('layout.admin')
@section('title', 'Persetujuan Penjual')
@section('page_title', 'Persetujuan Penjual')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4"><h6 class="mb-2 dark:text-white">Daftar Penjual Menunggu Persetujuan</h6></div>
            <div class="flex-auto p-4">
                @if (session('success')) <div class="px-4 py-3 mb-4 text-white bg-green-500 rounded-lg">{{ session('success') }}</div> @endif
                @if($pendingUsers->count())
                    <div class="overflow-x-auto">
                        <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Penjual</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No. Lisensi</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Dokumen</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingUsers as $user)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $user->nama }}</h6>
                                                <p class="mb-0 text-xs leading-tight dark:text-white/80 text-slate-400">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <p class="mb-0 text-sm font-semibold leading-tight dark:text-white">{{ $user->nomor_lisensi ?? '-' }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        @if($user->file_lisensi)
                                            <a href="{{ asset('storage/lisensi_penjual/' . $user->file_lisensi) }}" target="_blank" class="text-sm font-semibold leading-tight text-blue-500">Lihat File</a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                        <form method="POST" action="{{ route('admin.approval.approve', $user->id) }}">
                                            @csrf
                                            <button type="submit" class="inline-block px-5 py-2.5 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:shadow-xs active:opacity-85 text-xs ease-in shadow-md bg-gradient-to-tl from-emerald-500 to-teal-400">Setujui</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center border-dashed rounded-lg border-2 border-gray-200"><p class="text-sm text-slate-500">Tidak ada penjual yang menunggu persetujuan.</p></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection