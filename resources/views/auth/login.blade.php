@extends('layout.auth')
@section('title', 'Masuk Akun')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5" style="min-height:100vh;">
    <div class="card shadow-lg border-0 rounded-4" style="max-width:400px; width:100%;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="fa fa-user-circle fa-3x text-primary mb-2"></i>
                <h3 class="fw-bold mb-0">Masuk Akun</h3>
            </div>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-3" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control rounded-3" required>
                </div>
                <button class="btn btn-primary w-100 rounded-pill fw-bold py-2"><i class="fa fa-sign-in-alt me-2"></i> Masuk</button>
                <a class="btn btn-outline-primary w-100 mt-3 rounded-pill fw-bold py-2" href="{{ route('register') }}"><i class="fa fa-user-plus me-2"></i> Daftar Akun</a>
                <a class="btn btn-outline-secondary w-100 mt-2 rounded-pill fw-bold py-2" href="{{ route('home') }}"><i class="fa fa-arrow-left me-2"></i> Kembali ke Beranda</a>
            </form>
        </div>
    </div>
</div>
@endsection