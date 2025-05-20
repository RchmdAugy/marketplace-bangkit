@extends('layout.public')
@section('title', 'Edit Produk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Ubah Produk</h2>

<form action="{{ route('produk.update', $produk->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="form-label">Nama Produk:</label>
        <input type="text" name="nama" value="{{ $produk->nama }}" required class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Deskripsi:</label>
        <textarea name="deskripsi" required class="form-control">{{ $produk->deskripsi }}</textarea>
    </div>
    <div class="form-group">
        <label class="form-label">Harga (Rp):</label>
        <input type="number" name="harga" value="{{ $produk->harga }}" required class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Stok:</label>
        <input type="number" name="stok" value="{{ $produk->stok }}" required class="form-control">
    </div>
    <button class="btn btn-primary btn-sm" type="submit">Perbarui</button>
    <a class="btn btn-primary btn-sm" href="{{ route('produk.index') }}">Kembali</a>
</form>
@endsection
