@extends('layout.public')

@section('title', 'Persetujuan Penjual')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Daftar Penjual Menunggu Persetujuan</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($pendingUsers->count())
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0 rounded-4 overflow-hidden">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width:150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingUsers as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.approval.approve', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 py-2 fw-bold">Setujui</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm rounded-4 py-4">
            Tidak ada penjual yang menunggu persetujuan saat ini.
        </div>
    @endif
</div>
@endsection
