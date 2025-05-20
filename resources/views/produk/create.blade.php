@extends('layout.public')
@section('title', 'Tambah Produk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Tambah Produk Baru</h2>

<form action="{{ route('produk.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama Produk:</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Deskripsi:</label>
        <textarea name="deskripsi" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Harga (Rp):</label>
        <input type="number" name="harga" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stok:</label>
        <input type="number" name="stok" class="form-control" required>
    </div>

    <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
    <a class="btn btn-secondary" href="{{ route('produk.index') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
</form>
@endsection
