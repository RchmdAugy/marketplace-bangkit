@extends('layout.auth')

@section('title', 'Daftar Akun')
@section('showcase-title', 'Bergabung dengan Ribuan UMKM Hebat')

@section('content')
    <div class="w-100">
        <h3 class="fw-bold mb-1">Daftar Akun Baru</h3>
        <p class="text-muted mb-4">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--primary-color); font-weight: 500;">Masuk di sini</a></p>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label fw-medium">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Nama Anda">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@gmail.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 8 Karakter" minlength="8">
            </div>
            
            <div class="d-grid mt-4">
                <button class="btn btn-primary w-100 fw-bold py-2" type="submit"><i class="fa fa-user-plus me-2"></i> Daftar Akun</button>
            </div>
        </form>
    </div>
@endsection