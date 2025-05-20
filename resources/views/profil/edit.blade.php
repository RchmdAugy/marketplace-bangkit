
@extends('layout.public')
@section('title', 'Edit Profil')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h3 class="fw-bold mb-3 text-primary">Edit Profil</h3>
                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin ganti)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success rounded-pill px-4"><i class="fa fa-save"></i> Simpan</button>
                        <a href="{{ route('profil.show') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="fa fa-arrow-left"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection