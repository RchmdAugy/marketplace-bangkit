
@extends('layout.public')
@section('title', 'Edit Produk')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Ubah Produk</h2>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Produk:</label>
                        <input type="text" name="nama" value="{{ $produk->nama }}" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <textarea name="deskripsi" required class="form-control">{{ $produk->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp):</label>
                        <input type="number" name="harga" value="{{ $produk->harga }}" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok:</label>
                        <input type="number" name="stok" value="{{ $produk->stok }}" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Produk:</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        @if($produk->foto)
                            <div class="mt-2">
                                <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" width="120" class="rounded shadow">
                            </div>
                        @endif
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-primary rounded-pill px-4" type="submit"><i class="fa fa-save"></i> Perbarui</button>
                        <a class="btn btn-outline-secondary rounded-pill px-4" href="{{ route('produk.index') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection