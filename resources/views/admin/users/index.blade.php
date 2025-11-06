@extends('layout.admin')

@section('title', 'Kelola User')
@section('page_title', 'Kelola User')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between">
                    <h6 class="mb-2 dark:text-white">Daftar Pengguna (Admin & Pembeli)</h6>
                    <a href="{{ route('admin.users.create') }}" class="inline-block px-4 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem border-blue-500 text-blue-500 hover:opacity-75">
                        Tambah User
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
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Role</th>
                            {{-- DIHAPUS: Kolom Status Akun --}}
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
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
                                <p class="mb-0 text-sm font-semibold leading-tight dark:text-white">{{ ucfirst($user->role) }}</p>
                            </td>
                            
                            {{-- DIHAPUS: Kolom Status Akun (Menunggu/Disetujui) --}}

                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-xs font-semibold leading-tight dark:text-white text-slate-400"> Edit </a>
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-xs font-semibold leading-tight text-red-500"> Hapus </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            {{-- DIUBAH: colspan dari 4 menjadi 3 --}}
                            <td colspan="3" class="p-4 text-center text-sm text-slate-500">Tidak ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
