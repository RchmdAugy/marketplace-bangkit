
@extends('layout.auth')
@section('title', 'Masuk Akun')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="auth-card" style="max-width:400px; width:100%;">
        <div class="text-center mb-4">
            <i class="fa fa-user-circle fa-3x text-primary mb-2"></i>
            <h3 class="auth-title mb-0">Masuk Akun</h3>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100 rounded-pill fw-semibold"><i class="fa fa-sign-in-alt"></i> Masuk</button>
            <a class="btn btn-outline-primary w-100 mt-2 rounded-pill fw-semibold" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Daftar Akun</a>
            <a class="btn btn-outline-success w-100 mt-2 rounded-pill fw-semibold" href="{{ route('home') }}"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>
        </form>
    </div>
</div>
@endsection