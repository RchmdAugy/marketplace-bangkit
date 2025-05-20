
@extends('layout.auth')
@section('title', 'Daftar Akun')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="auth-card" style="max-width:500px; width:100%;">
        <div class="text-center mb-4">
            <i class="fa fa-user-plus fa-3x text-success mb-2"></i>
            <h3 class="auth-title mb-0">Daftar Akun Baru</h3>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Peran</label>
                <select name="role" class="form-select" required>
                    <option value="pembeli">Pembeli</option>
                    <option value="penjual">Penjual</option>
                </select>
            </div>
            <button class="btn btn-success w-100 rounded-pill fw-semibold"><i class="fa fa-user-plus"></i> Daftar</button>
            <a class="btn btn-outline-primary w-100 mt-2 rounded-pill fw-semibold" href="{{ route('login') }}"><i class="fa fa-arrow-left"></i> Kembali ke Login</a>
        </form>
    </div>
</div>
@endsection