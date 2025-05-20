
@extends('layout.public')
@section('title', 'Profil Saya')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h3 class="fw-bold mb-3 text-primary">Profil Akun</h3>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Nama:</strong> {{ $user->nama }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Peran:</strong> {{ ucfirst($user->role) }}</li>
                </ul>
                <a href="{{ route('profil.edit') }}" class="btn btn-primary rounded-pill"><i class="fa fa-edit"></i> Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection