@extends('layout.public')
@section('title', 'Profil Saya')
@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4 text-center">Profil Akun</h3>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <strong class="text-dark">Nama:</strong> 
                        <span>{{ $user->nama }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <strong class="text-dark">Email:</strong> 
                        <span>{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <strong class="text-dark">Peran:</strong> 
                        <span>{{ ucfirst($user->role) }}</span>
                    </li>
                </ul>
                <div class="text-center">
                    <a href="{{ route('profil.edit') }}" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="fa fa-edit me-2"></i> Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection