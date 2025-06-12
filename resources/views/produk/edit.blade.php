@extends('layout.public')
@section('title', 'Edit Produk')

@section('content')
<h2 class="mb-4 fw-bold text-center">Ubah Produk</h2>
<div class="row justify-content-center py-4">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk:</label>
                        <input type="text" name="nama" id="nama" value="{{ $produk->nama }}" required class="form-control rounded-3">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi:</label>
                        <textarea name="deskripsi" id="deskripsi" required class="form-control rounded-3" rows="4">{{ $produk->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga (Rp):</label>
                        <input type="number" name="harga" id="harga" value="{{ $produk->harga }}" required class="form-control rounded-3">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok:</label>
                        <input type="number" name="stok" id="stok" value="{{ $produk->stok }}" required class="form-control rounded-3">
                    </div>
                    <div class="mb-4">
                        <label for="foto" class="form-label">Foto Produk:</label>
                        <input type="file" name="foto" id="foto" class="form-control rounded-3" accept="image/*">
                        @if($produk->foto)
                            <div class="mt-2 text-center">
                                <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" width="150" class="rounded shadow-sm border p-1">
                            </div>
                        @endif
                    </div>
                    <div class="d-flex gap-2 mt-3 justify-content-center">
                        <button class="btn btn-primary rounded-pill px-4 fw-bold py-2" type="submit"><i class="fa fa-save me-2"></i> Perbarui</button>
                        <a class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2" href="{{ route('produk.index') }}"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection