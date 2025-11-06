@extends('layout.admin')

@section('title', 'Tambah User Baru')
@section('page_title', 'Tambah User')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 rounded-t-4">
                <h6 class="mb-2 dark:text-white">Formulir User Baru</h6>
            </div>
            <div class="flex-auto p-4">
                @if ($errors->any())
                    <div class="text-white px-6 py-4 border-0 rounded-lg relative mb-4 bg-red-500">
                        <span class="inline-block align-middle mr-8">
                            Terdapat kesalahan pada input Anda.
                        </span>
                    </div>
                @endif
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nama" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                        @error('nama') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Password</label>
                        <input type="password" id="password" name="password" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                        @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block mb-2 text-sm font-bold text-slate-700 dark:text-white/80">Role</label>
                        <select id="role" name="role" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" required>
                            <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin.users.index') }}" class="inline-block px-4 py-2 mr-2 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem border-slate-700 text-slate-700 hover:opacity-75">Batal</a>
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 border-0 rounded-lg cursor-pointer leading-pro ease-in-out text-xs hover:scale-102 active:shadow-xs tracking-tight-rem shadow-md hover:shadow-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection