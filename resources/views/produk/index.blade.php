@extends('layout.public')
@section('title', 'Daftar Produk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Daftar Produk</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(Auth::check() && Auth::user()->role == 'penjual')
    <a class="btn btn-success mb-3" href="{{ route('produk.create') }}"><i class="fa fa-plus"></i> Tambah Produk</a>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($produks as $produk)
        <tr>
            <td>{{ $produk->nama }}</td>
            <td>Rp {{ number_format($produk->harga,0,',','.') }}</td>
            <td>{{ $produk->stok }}</td>
            <td>
                <a class="btn btn-primary btn-sm" href="{{ route('produk.show', $produk->id) }}"><i class="fa fa-eye"></i> Detail</a>
                @if(Auth::check() && Auth::user()->id == $produk->user_id)
                    <a class="btn btn-warning btn-sm" href="{{ route('produk.edit', $produk->id) }}"><i class="fa fa-edit"></i> Ubah</a>
                    <a class="btn btn-danger btn-sm" href="{{ route('produk.delete', $produk->id) }}" onclick="return confirm('Yakin hapus?')"><i class="fa fa-trash"></i> Hapus</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
