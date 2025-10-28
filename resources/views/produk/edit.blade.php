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
                        @method('PUT')

                        {{-- Nama, Deskripsi --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium">Nama Produk</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required class="form-control @error('nama') is-invalid @enderror">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-medium">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" required class="form-control @error('deskripsi') is-invalid @enderror" rows="5">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                             @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- ========================================= --}}
                        {{-- ==     DROPDOWN KATEGORI (BARU)        == --}}
                        {{-- ========================================= --}}
                        <div class="mb-3">
                             <label for="category_id" class="form-label fw-medium">Kategori Produk</label>
                             <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                 <option value="" disabled>-- Pilih Kategori --</option>
                                 @foreach($categories as $category)
                                     <option value="{{ $category->id }}" {{ old('category_id', $produk->category_id) == $category->id ? 'selected' : '' }}>
                                         {{ $category->name }}
                                     </option>
                                 @endforeach
                             </select>
                             @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        {{-- ========================================= --}}


                        {{-- Harga, Stok --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label fw-medium">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" required class="form-control @error('harga') is-invalid @enderror" min="0">
                                 @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-medium">Stok</label>
                                <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" required class="form-control @error('stok') is-invalid @enderror" min="0">
                                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Ganti Foto Utama --}}
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-medium">Ganti Foto Utama (Opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'image-preview-main')">
                            @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <div class="mt-3">
                                <small>Foto Saat Ini:</small><br>
                                @if($produk->foto)
                                    <img id="image-preview-main" src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" class="rounded shadow-sm border p-1" style="max-height: 150px;">
                                @else
                                    <img id="image-preview-main" src="" alt="Tidak ada foto utama" class="rounded shadow-sm border p-1" style="max-height: 150px; display: none;">
                                    <small class="text-muted">Belum ada foto utama.</small>
                                @endif
                            </div>
                        </div>

                        {{-- Kelola Galeri Foto --}}
                        <hr class="my-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Kelola Foto Galeri</label>
                            @if($produk->images->count() > 0)
                            <p class="mb-2"><small>Pilih gambar yang ingin dihapus:</small></p>
                            <div class="d-flex flex-wrap gap-3 mb-3 border p-3 rounded-3">
                                @foreach($produk->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('foto_produk_gallery/'.$image->image_path) }}" class="rounded border p-1" style="height: 80px; width: 80px; object-fit: cover;">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="form-check-input position-absolute top-0 end-0 m-1" title="Pilih untuk hapus">
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <p class="text-muted"><small>Belum ada gambar galeri.</small></p>
                            @endif
                             @error('delete_images.*') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="gallery_images" class="form-label fw-medium">Tambah Foto Galeri Baru (Opsional)</label>
                            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control @error('gallery_images.*') is-invalid @enderror" accept="image/*" multiple onchange="previewGalleryImages(this, 'gallery-preview-new')">
                            @error('gallery_images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <small class="text-muted">Anda bisa memilih lebih dari satu gambar baru.</small>
                            <div id="gallery-preview-new" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>

                        {{-- Tombol --}}
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
{{-- Library SweetAlert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    // Fungsi preview untuk SATU gambar (Foto Utama)
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

    // Fungsi preview untuk BANYAK gambar (Galeri)
    function previewGalleryImages(input, previewContainerId) {
        const previewContainer = document.getElementById(previewContainerId);
        previewContainer.innerHTML = ''; // Kosongkan preview lama
        if (input.files && input.files.length > 0) {
            // Batasi jumlah preview jika terlalu banyak (opsional)
            const maxPreview = 10; 
            const filesToPreview = Math.min(input.files.length, maxPreview);

            for (let i = 0; i < filesToPreview; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.classList.add('position-relative'); // Untuk tombol hapus nanti (jika perlu)
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxHeight = '100px'; // Ukuran preview kecil
                    img.classList.add('rounded-3', 'border', 'p-1', 'mb-1'); // Tambah margin bottom
                    
                    imgWrapper.appendChild(img);
                    previewContainer.appendChild(imgWrapper);
                }
                reader.readAsDataURL(input.files[i]);
            }
             // Beri tahu jika file > maxPreview
            if (input.files.length > maxPreview) {
                 const infoText = document.createElement('small');
                 infoText.classList.add('text-muted', 'd-block', 'w-100', 'mt-1');
                 infoText.textContent = `Hanya ${maxPreview} dari ${input.files.length} gambar ditampilkan sebagai preview.`;
                 previewContainer.appendChild(infoText);
            }
        }
    }

    // Script SweetAlert 
    @if(session('success'))
        swal({ 
            title: "Berhasil!", 
            text: "{{ session('success') }}", 
            icon: "success", 
            button: "OK", 
        });
    @endif
    @if ($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error) 
            errorMessages += "- {{ $error }}\n"; // Tambah bullet point
        @endforeach
        swal({ 
            title: "Oops, Gagal!", 
            text: errorMessages, 
            icon: "error", 
            button: "Coba Lagi", 
        });
    @endif
</script>
@endpush