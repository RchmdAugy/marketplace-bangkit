@extends('layout.public')
@section('title', 'Tambah Produk Baru')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold">Formulir Tambah Produk Baru</h4>
                </div>
                <div class="card-body p-4 p-lg-5">

                    <div class="alert alert-info d-flex align-items-center rounded-3 shadow-sm" role="alert">
                       <i class="fas fa-info-circle fa-lg me-3"></i>
                       <div>Produk yang Anda tambahkan akan ditinjau oleh Admin sebelum ditampilkan di marketplace.</div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm" role="alert">
                            <h5 class="alert-heading fw-semibold"><i class="fas fa-exclamation-triangle me-2"></i> Oops! Terjadi Kesalahan:</h5>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-lg rounded-3 @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required placeholder="Contoh: Keripik Singkong Balado">
                             @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_umkm" class="form-label fw-semibold">Nama UMKM / Pembuat Produk</label>
                            <input type="text" name="nama_umkm" id="nama_umkm" class="form-control form-control-lg rounded-3 @error('nama_umkm') is-invalid @enderror" value="{{ old('nama_umkm') }}" required placeholder="Contoh: Ibu Siti Aminah">
                             <small class="text-muted">Masukkan nama orang atau UMKM yang membuat produk ini.</small>
                             @error('nama_umkm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control form-control-lg rounded-3 @error('deskripsi') is-invalid @enderror" rows="5" required placeholder="Jelaskan keunikan produk Anda...">{{ old('deskripsi') }}</textarea>
                             @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-semibold">Kategori Produk</label>
                                <select name="category_id" id="category_id" class="form-select form-select-lg rounded-3 @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                 @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga" class="form-control form-control-lg rounded-3 @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required min="0" placeholder="Contoh: 15000">
                                 @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control form-control-lg rounded-3 @error('stok') is-invalid @enderror" value="{{ old('stok') }}" required min="0" placeholder="Jumlah stok tersedia">
                             @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-semibold">Foto Utama Produk</label>
                            <input type="file" name="foto" id="foto" class="form-control form-control-lg rounded-3 @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'image-preview-main')">
                             <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maks: 2MB.</small>
                             @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <img id="image-preview-main" class="mt-3 rounded-3 border p-1 shadow-sm" style="max-height: 200px; display: none;">
                        </div>
                        <div class="mb-4">
                            <label for="gallery_images" class="form-label fw-semibold">Foto Galeri Tambahan (Opsional)</label>
                            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control form-control-lg rounded-3 @error('gallery_images.*') is-invalid @enderror" accept="image/*" multiple onchange="previewGalleryImages(this, 'gallery-preview')">
                            <small class="text-muted">Anda bisa memilih lebih dari satu gambar. Maks: 2MB per gambar.</small>
                             @error('gallery_images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <div id="gallery-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm"><i class="fas fa-plus-circle me-2"></i> Tambahkan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
 function previewImage(input, previewId) {
        const imgPreview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(input.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        } else {
             imgPreview.style.display = 'none';
             imgPreview.src = '';
        }
    }

    function previewGalleryImages(input, previewContainerId) {
        const previewContainer = document.getElementById(previewContainerId);
        previewContainer.innerHTML = '';
        if (input.files && input.files.length > 0) {
            const maxPreview = 10;
            const filesToPreview = Math.min(input.files.length, maxPreview);
            for (let i = 0; i < filesToPreview; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.classList.add('position-relative');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxHeight = '100px';
                    img.classList.add('rounded-3', 'border', 'p-1', 'mb-1', 'shadow-sm');
                    imgWrapper.appendChild(img);
                    previewContainer.appendChild(imgWrapper);
                }
                reader.readAsDataURL(input.files[i]);
            }
            if (input.files.length > maxPreview) {
                const infoText = document.createElement('small');
                infoText.classList.add('text-muted', 'd-block', 'w-100', 'mt-1');
                infoText.textContent = `Hanya ${maxPreview} dari ${input.files.length} gambar ditampilkan sebagai preview.`;
                previewContainer.appendChild(infoText);
            }
        }
    }
</script>
<script>
    @if(session('success'))
        swal({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            button: "OK",
        });
    @endif
    @if ($errors->any())
        let errorMessages = 'Oops! Terjadi kesalahan:\n\n';
        @foreach ($errors->all() as $error)
            errorMessages += "- {{ $error }}\n";
        @endforeach
        swal({
            title: "Gagal!",
            text: errorMessages,
            icon: "error",
            button: "Coba Lagi",
        });
    @endif
</script>
@endpush