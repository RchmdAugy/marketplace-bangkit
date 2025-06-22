@extends('layout.public')
@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-lg-5">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <img src="{{ $user->foto_profil ? asset('foto_profil/'.$user->foto_profil) : 'https://ui-avatars.com/api/?name='.$user->nama.'&background=10B981&color=fff&size=128' }}" class="img-fluid rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover;" alt="Foto Profil">
                        <h3 class="fw-bold mb-0">{{ $user->role == 'penjual' && $user->nama_toko ? $user->nama_toko : $user->nama }}</h3>
                        <p class="text-muted">{{ $user->email }}</p>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill fs-6">{{ ucfirst($user->role) }}</span>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-semibold mb-3 text-center">Detail Informasi</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong class="text-muted">Nama Personal</strong>
                            <span>{{ $user->nama }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong class="text-muted">Nomor Telepon</strong>
                            <span>{{ $user->no_telepon ?? 'Belum diisi' }}</span>
                        </li>
                        @if($user->role == 'penjual')
                        <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                            <strong class="text-muted">Alamat Toko</strong>
                            <span class="text-end" style="white-space: pre-wrap;">{{ $user->alamat_toko ?? 'Belum diisi' }}</span>
                        </li>
                        @endif
                    </ul>

                    <div class="text-center mt-5">
                        <a href="{{ route('profil.edit') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold">
                            <i class="fa fa-edit me-2"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection