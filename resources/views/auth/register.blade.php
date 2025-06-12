@extends('layout.auth')
@section('title', 'Daftar Akun')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5" style="min-height:100vh;">
    <div class="card shadow-lg border-0 rounded-4" style="max-width:500px; width:100%;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="fa fa-user-plus fa-3x text-primary mb-2"></i>
                <h3 class="fw-bold mb-0">Daftar Akun Baru</h3>
            </div>
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
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control rounded-3" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-3" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control rounded-3" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">Peran</label>
                    <select name="role" id="role" class="form-select rounded-3" required>
                        <option value="pembeli">Pembeli</option>
                        <option value="penjual">Penjual</option>
                    </select>
                </div>
                <button class="btn btn-primary w-100 rounded-pill fw-bold py-2"><i class="fa fa-user-plus me-2"></i> Daftar</button>
                <a class="btn btn-outline-secondary w-100 mt-3 rounded-pill fw-bold py-2" href="{{ route('login') }}"><i class="fa fa-arrow-left me-2"></i> Kembali ke Login</a>
            </form>
        </div>
    </div>
</div>
@endsection