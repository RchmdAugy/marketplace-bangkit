@extends('layout.public')
@section('title', 'Tambah Produk')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="fw-bold text-center mb-4">Tambah Produk Baru</h2>
                    <p class="text-center text-muted mb-4">Produk Anda akan ditinjau oleh Admin sebelum ditampilkan di marketplace.</p>
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control" required placeholder="Contoh: Keripik Singkong Balado">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-medium">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required placeholder="Jelaskan keunikan produk Anda..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label fw-medium">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga" class="form-control" required placeholder="Contoh: 15000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-medium">Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control" required placeholder="Jumlah stok tersedia">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-medium">Foto Produk</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage()">
                            <img id="image-preview" class="mt-3 rounded-3" style="max-height: 200px; display: none;">
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

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-outline-secondary rounded-pill px-4" href="{{ route('produk.index') }}">Batal</a>
                            <button class="btn btn-primary rounded-pill px-5 py-2" type="submit"><i class="fa fa-save me-2"></i>Simpan Produk</button>
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