@extends('layout.public')

@section('title', 'Persetujuan Penjual')

@section('content')
<div class="container mt-4">
    <h2>Daftar Penjual Menunggu Persetujuan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
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
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
   
</div>
@endsection
