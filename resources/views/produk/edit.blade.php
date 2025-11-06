@extends('layout.public')
@section('title', 'Edit Produk: ' . $produk->nama)

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                 <div class="card-header bg-primary text-white py-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold">Formulir Edit Produk</h4>
                </div>
                <div class="card-body p-4 p-lg-5">

                    @if(Auth::user()->role == 'penjual')
                    <div class="alert alert-info d-flex align-items-center rounded-3 shadow-sm" role="alert">
                       <i class="fas fa-info-circle fa-lg me-3"></i>
                       <div>Perubahan pada produk mungkin memerlukan persetujuan ulang oleh Admin.</div>
                    </div>
                    @endif

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

                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Produk</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required class="form-control form-control-lg rounded-3 @error('nama') is-invalid @enderror">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_umkm" class="form-label fw-semibold">Nama UMKM / Pembuat Produk</label>
                            <input type="text" name="nama_umkm" id="nama_umkm" class="form-control form-control-lg rounded-3 @error('nama_umkm') is-invalid @enderror" value="{{ old('nama_umkm', $produk->nama_umkm) }}" required placeholder="Contoh: Ibu Siti Aminah">
                             <small class="text-muted">Masukkan nama orang atau UMKM yang membuat produk ini.</small>
                             @error('nama_umkm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" required class="form-control form-control-lg rounded-3 @error('deskripsi') is-invalid @enderror" rows="5">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                         <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="category_id" class="form-label fw-semibold">Kategori Produk</label>
                                <select name="category_id" id="category_id" class="form-select form-select-lg rounded-3 @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $produk->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" required class="form-control form-control-lg rounded-3 @error('harga') is-invalid @enderror" min="0">
                                @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="stok" class="form-label fw-semibold">Stok</label>
                                <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" required class="form-control form-control-lg rounded-3 @error('stok') is-invalid @enderror" min="0">
                                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label fw-semibold">Ganti Foto Utama (Opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control form-control-lg rounded-3 @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'image-preview-main')">
                            @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <div class="mt-3">
                                <small>Foto Saat Ini:</small><br>
                                @if($produk->foto && file_exists(public_path('foto_produk/'.$produk->foto)))
                                    <img id="image-preview-current" src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk Saat Ini" class="rounded-3 shadow-sm border p-1" style="max-height: 150px;">
                                    <img id="image-preview-main" src="" alt="Preview Foto Baru" class="rounded-3 shadow-sm border p-1" style="max-height: 150px; display: none;">
                                @else
                                     <img id="image-preview-current" src="" style="display: none;">
                                     <img id="image-preview-main" src="" alt="Preview Foto Baru" class="rounded-3 shadow-sm border p-1" style="max-height: 150px; display: none;">
                                    <small class="text-muted">Belum ada foto utama.</small>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelola Foto Galeri</label>
                            @if($produk->images->count() > 0)
                            <p class="mb-2"><small>Pilih gambar yang ingin dihapus:</small></p>
                            <div class="d-flex flex-wrap gap-3 mb-3 border p-3 rounded-3 bg-light shadow-sm">
                                @foreach($produk->images as $image)
                                    <div class="position-relative gallery-item">
                                        <img src="{{ asset('foto_produk_gallery/'.$image->image_path) }}" class="rounded border p-1 shadow-sm" style="height: 80px; width: 80px; object-fit: cover;">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="form-check-input position-absolute top-0 end-0 m-1 bg-danger border-danger shadow" title="Pilih untuk hapus">
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <p class="text-muted"><small>Belum ada gambar galeri.</small></p>
                            @endif
                            @error('delete_images.*') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="gallery_images" class="form-label fw-semibold">Tambah Foto Galeri Baru (Opsional)</label>
                            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control form-control-lg rounded-3 @error('gallery_images.*') is-invalid @enderror" accept="image/*" multiple onchange="previewGalleryImages(this, 'gallery-preview-new')">
                            @error('gallery_images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <small class="text-muted">Anda bisa memilih lebih dari satu gambar baru.</small>
                            <div id="gallery-preview-new" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm"><i class="fas fa-save me-2"></i>Perbarui Produk</button>
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
        const currentPreview = document.getElementById('image-preview-current');
        if (input.files && input.files[0]) {
            imgPreview.style.display = 'block';
            if(currentPreview) currentPreview.style.display = 'none';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(input.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        } else {
             imgPreview.style.display = 'none';
             imgPreview.src = '';
             if(currentPreview && currentPreview.hasAttribute('src') && currentPreview.getAttribute('src') !== '') {
                 currentPreview.style.display = 'block';
             }
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

    @if(session('success'))
        swal({ title: "Berhasil!", text: "{{ session('success') }}", icon: "success", button: "OK" });
    @endif
    @if ($errors->any())
        let errorMessages = 'Oops! Terjadi kesalahan:\n\n';
        @foreach ($errors->all() as $error) errorMessages += "- {{ $error }}\n"; @endforeach
        swal({ title: "Gagal!", text: errorMessages, icon: "error", button: "Coba Lagi" });
    @endif
</script>
@endpush