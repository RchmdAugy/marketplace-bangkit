
@extends('layout.public')
@section('title', 'Tambah Produk')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Tambah Produk Baru</h2>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="mb-3">
                        <label class="form-label">Foto Produk:</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-success rounded-pill px-4"><i class="fa fa-save"></i> Simpan</button>
                        <a class="btn btn-outline-secondary rounded-pill px-4" href="{{ route('produk.index') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection