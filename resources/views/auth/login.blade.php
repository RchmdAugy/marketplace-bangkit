@extends('layout.auth')

@section('title', 'Masuk Akun')
@section('showcase-title', 'Selamat Datang Kembali!')

@section('content')
    <div class="w-100">
        <h3 class="fw-bold mb-1">Masuk ke Akun Anda</h3>
        <p class="text-muted mb-4">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--primary-color); font-weight: 500;">Daftar di sini</a></p>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus placeholder="contoh@gmail.com">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-medium">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••" minlength="8">
            </div>
            <div class="d-grid">
                <button class="btn btn-primary fw-bold py-2" type="submit"><i class="fa fa-sign-in-alt me-2"></i> Masuk</button>
            </div>
            <div class="text-center mt-3">
                <a class="btn btn-link text-secondary text-decoration-none" href="{{ route('home') }}">
                    <i class="fa fa-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>
@endsection