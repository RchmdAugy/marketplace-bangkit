@extends('layout.public')
@section('title', 'Masuk Akun')

@section('content')
<div class="card mx-auto" style="max-width: 400px; text-align: left; margin-top: 100px;padding-top: 20px" >
    <h4 class="card-title text-center mb-3">Masuk Akun</h4>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="margin-left: 20px; margin-right: 20px;">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100"><i class="fa fa-sign-in-alt"></i> Masuk</button>
        <a class="btn btn-secondary w-100 mt-2" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Daftar Akun</a>
    </form>
</div>
@endsection
