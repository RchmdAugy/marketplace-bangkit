@extends('layout.public')
@section('title', 'Edit Produk')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="fw-bold text-center mb-4">Ubah Produk</h2>
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium">Nama Produk</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-medium">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" required class="form-control" rows="5">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label fw-medium">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" required class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-medium">Stok</label>
                                <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" required class="form-control">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-medium">Ganti Foto Produk</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage()">
                            <div class="mt-3">
                                <small>Foto Saat Ini:</small><br>
                                <img id="image-preview" src="{{ $produk->foto ? asset('foto_produk/'.$produk->foto) : '' }}" alt="Foto Produk" class="rounded shadow-sm border p-1" style="max-height: 150px;">
                            </div>
                        </div>

                        @if($errors->any())
                            {{-- Error handling --}}
                        @endif
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <a class="btn btn-outline-secondary rounded-pill px-4" href="{{ route('produk.index') }}">Batal</a>
                             <button class="btn btn-primary rounded-pill px-5 py-2" type="submit"><i class="fa fa-save me-2"></i>Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('#image-preview');
        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endpush