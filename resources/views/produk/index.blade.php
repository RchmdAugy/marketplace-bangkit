
@extends('layout.public')
@section('title', 'Daftar Produk')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Daftar Produk</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(Auth::check() && Auth::user()->role == 'penjual')
    <a class="btn btn-success mb-3 shadow rounded-pill px-4" href="{{ route('produk.create') }}"><i class="fa fa-plus"></i> Tambah Produk</a>
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
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
                            <a class="btn btn-outline-primary btn-sm rounded-pill" href="{{ route('produk.show', $produk->id) }}"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-outline-warning btn-sm rounded-pill" href="{{ route('produk.edit', $produk->id) }}"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-outline-danger btn-sm rounded-pill" href="{{ route('produk.delete', $produk->id) }}" onclick="return confirm('Yakin hapus?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
<div class="row g-4">
    @foreach($produks as $produk)
    <div class="col-md-4">
        <div class="card h-100 shadow border-0 rounded-4 produk-card">
            @if($produk->foto)
                <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="card-img-top rounded-top-4" alt="Foto Produk" style="height:220px;object-fit:cover;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height:220px;">
                    <i class="fa fa-image fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold text-dark mb-1" style="font-size:1.2rem;">{{ $produk->nama }}</h5>
                <p class="card-text text-muted mb-2" style="min-height:40px;">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 60) }}</p>
                <p class="card-text fw-bold fs-5 mb-3" style="color:#1abc9c;">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-outline-primary w-100 fw-semibold rounded-pill py-2 mt-auto" style="border-width:2px;">
                    <i class="fa fa-eye"></i> Detail Produk
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<style>
.produk-card:hover {
    box-shadow: 0 8px 32px rgba(26,188,156,0.15) !important;
    transform: translateY(-4px);
    transition: .2s;
}
</style>
@endsection