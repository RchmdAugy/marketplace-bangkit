@extends('layout.public')
@section('title', 'Daftar Akun')

@section('content')
<div class="card mx-auto" style="max-width: 500px; text-align: left; margin-top: 100px;padding-top: 20px;">
    <h4 class="card-title text-center mb-3">Daftar Akun Baru</h4>

    <form method="POST" action="{{ route('register') }}  "style="margin-left: 20px; margin-right: 20px;">
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
        <button class="btn btn-success w-100"><i class="fa fa-user-plus"></i> Daftar</button>
        <a class="btn btn-secondary w-100 mt-2" href="{{ route('login') }}"><i class="fa fa-arrow-left"></i> Kembali ke Login</a>
    </form>
</div>
@endsection
