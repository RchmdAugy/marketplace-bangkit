@extends('layout.public')
@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10"> {{-- Lebar kolom yang lebih responsif --}}
            <div class="card shadow-lg border-0 rounded-4"> {{-- Shadow lebih kuat --}}
                <div class="card-body p-4 p-lg-5">

                    {{-- Bagian Header Profil --}}
                    <div class="text-center mb-5">
                        <img src="{{ $user->foto_profil ? asset('foto_profil/'.$user->foto_profil) : 'https://ui-avatars.com/api/?name='.$user->nama.'&background=10B981&color=fff&size=140' }}" 
                             class="img-fluid rounded-circle shadow-lg mb-3 profile-avatar-lg" {{-- Class baru untuk avatar lebih besar --}}
                             alt="{{ $user->role == 'penjual' && $user->nama_toko ? $user->nama_toko : $user->nama }}">
                        
                        <h3 class="fw-bold text-secondary mb-1">
                            {{ $user->role == 'penjual' && $user->nama_toko ? $user->nama_toko : $user->nama }}
                        </h3>
                        <p class="text-muted mb-2">
                            @if($user->role == 'penjual' && $user->nama_toko) {{-- Tampilkan nama personal jika ada nama toko --}}
                                <small>({{ $user->nama }})</small> <br>
                            @endif
                            {{ $user->email }}
                        </p>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill fs-6 px-3 py-2 fw-bold">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <hr class="my-5 border-secondary opacity-25"> {{-- Garis pemisah lebih menonjol --}}

                    <h5 class="fw-bold mb-4 text-center text-primary">
                        <i class="fa fa-info-circle me-2"></i> Detail Informasi
                    </h5>
                    
                    <ul class="list-group list-group-flush profile-details-list"> {{-- Class baru untuk list --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <strong class="text-muted">Nama Personal</strong>
                            <span class="text-dark">{{ $user->nama }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <strong class="text-muted">Nomor Telepon</strong>
                            <span class="text-dark">{{ $user->no_telepon ?? 'Belum diisi' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <strong class="text-muted">Email</strong>
                            <span class="text-dark">{{ $user->email }}</span>
                        </li>
                        @if($user->role == 'penjual')
                        <li class="list-group-item d-flex justify-content-between align-items-start px-0 py-3">
                            <strong class="text-muted">Alamat Toko</strong>
                            <span class="text-dark text-end" style="white-space: pre-wrap;">{{ $user->alamat_toko ?? 'Belum diisi' }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <strong class="text-muted">Bergabung Sejak</strong>
                            <span class="text-dark">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                        </li>
                    </ul>

                    <div class="text-center mt-5">
                        <a href="{{ route('profil.edit') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow"> {{-- Tambah shadow pada tombol --}}
                            <i class="fa fa-edit me-2"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection