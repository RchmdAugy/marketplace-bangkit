@extends('layout.public')
@section('title', 'Edit Profil')
@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4 text-center">Edit Profil</h3>
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
                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control rounded-3" value="{{ old('nama', $user->nama) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin ganti)</small></label>
                        <input type="password" name="password" id="password" class="form-control rounded-3">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-3">
                    </div>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary rounded-pill px-4 fw-bold py-2"><i class="fa fa-save me-2"></i> Simpan</button>
                        <a href="{{ route('profil.show') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2"><i class="fa fa-arrow-left me-2"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection