@extends('layout.public')
@section('title', $produk->nama)

@push('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .product-gallery-thumbnails img { cursor: pointer; opacity: 0.6; transition: opacity 0.2s ease; border: 2px solid transparent; border-radius: 0.375rem; }
    .product-gallery-thumbnails img:hover,
    .product-gallery-thumbnails img.active { opacity: 1; border-color: var(--bs-primary); }
    .product-main-image-container { height: 400px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; }
    .product-main-image-container img { max-height: 100%; max-width: 100%; object-fit: contain; }
    .product-no-image { height: 400px; color: #adb5bd; }

    .product-tabs .nav-link { color: var(--bs-secondary-color); border: none; border-bottom: 2px solid transparent; margin-right: 0.5rem; padding: 0.8rem 1rem; font-weight: 500;}
    .product-tabs .nav-link.active { color: var(--bs-primary); border-bottom-color: var(--bs-primary); background-color: transparent !important; }
    .product-tabs .nav-link:hover { color: var(--bs-primary); }

    .avatar-circle { width: 40px; height: 40px; border-radius: 50%; font-size: 1rem;}

     .quantity-input { border-left: none; border-right: none; box-shadow: none !important; }
     .input-group .btn { border-color: #dee2e6; }
     .input-group .btn:hover { background-color: #e9ecef; }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row gx-lg-5 align-items-start">

                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="product-main-image-container border rounded-4 overflow-hidden shadow-sm mb-3">
                         @php
                            $mainImagePath = null;
                            $hasGallery = $produk->images->count() > 0;
                            if ($produk->foto && file_exists(public_path('foto_produk/' . $produk->foto))) {
                                $mainImagePath = asset('foto_produk/' . $produk->foto);
                            } elseif ($hasGallery && $produk->images->first() && file_exists(public_path('foto_produk_gallery/' . $produk->images->first()->image_path))) {
                                $mainImagePath = asset('foto_produk_gallery/' . $produk->images->first()->image_path);
                            }
                        @endphp

                        @if($mainImagePath)
                            <img src="{{ $mainImagePath }}" alt="Foto Produk {{ $produk->nama }}" class="img-fluid" id="mainProductImage">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center w-100 product-no-image"><i class="fa fa-image fa-5x opacity-50"></i></div>
                        @endif
                    </div>
                     <div class="product-gallery-thumbnails d-flex flex-wrap gap-2">
                         @php $firstActiveSkipped = !$produk->foto; @endphp
                         @if($produk->foto && file_exists(public_path('foto_produk/'.$produk->foto)))
                           <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Thumbnail 1"
                                class="border p-1 active" style="height: 60px; width: 60px; object-fit: cover;"
                                onclick="changeMainImage('{{ asset('foto_produk/'.$produk->foto) }}', this)">
                         @endif
                         @foreach($produk->images as $index => $image)
                             @if(file_exists(public_path('foto_produk_gallery/'.$image->image_path)))
                                 <img src="{{ asset('foto_produk_gallery/'.$image->image_path) }}"
                                      alt="Thumbnail {{ $index + ($produk->foto ? 2 : 1) }}"
                                      class="border p-1 {{ $firstActiveSkipped && $index == 0 ? 'active' : '' }}"
                                      style="height: 60px; width: 60px; object-fit: cover;"
                                      onclick="changeMainImage('{{ asset('foto_produk_gallery/'.$image->image_path) }}', this)">
                                 @php if($firstActiveSkipped && $index == 0) $firstActiveSkipped = false; @endphp
                             @endif
                         @endforeach
                    </div>
                </div>

                <div class="col-lg-7">
                    <h1 class="display-6 fw-bold mb-2 text-secondary">{{ $produk->nama }}</h1>
                    @if($produk->category)
                        <span class="badge bg-primary-subtle text-primary-emphasis mb-3 fs-6 rounded-pill px-3 py-1 shadow-sm">
                            <i class="fa fa-tag me-1"></i> {{ $produk->category->name }}
                        </span>
                    @endif

                    <div class="d-flex flex-wrap align-items-center mb-3 gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-store me-2 text-muted opacity-75"></i>
                            <span class="text-muted fw-medium me-1">Oleh:</span>
                            <a href="{{ route('toko.show', $produk->user->id) }}" class="text-decoration-none fw-semibold text-primary">
                                {{ $produk->nama_umkm ?? ($produk->user->nama_toko ?? $produk->user->nama) }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center">
                            @php
                                $averageRating = $produk->reviews->avg('rating') ?? 0;
                                $roundedRating = round($averageRating);
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $roundedRating ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                            @endfor
                            <span class="fw-semibold text-dark ms-2">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-muted ms-1 small">({{ $produk->reviews->count() }} ulasan)</span>
                        </div>
                    </div>

                    <p class="fs-2 fw-bold text-primary mb-4">Rp {{ number_format($produk->harga,0,',','.') }}</p>

                    <div class="d-flex align-items-center mb-4">
                        <span class="badge bg-secondary text-white p-2 fw-medium me-3 rounded-pill px-3 shadow-sm"><i class="fa fa-box me-1"></i> Stok: {{ $produk->stok }}</span>
                        @if($produk->stok <= 0)
                            <span class="text-danger fw-semibold"><i class="fas fa-times-circle me-1"></i> Produk Habis</span>
                        @else
                            <span class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i> Tersedia</span>
                        @endif
                    </div>

                    @if(Auth::check() && Auth::user()->role == 'pembeli' && $produk->stok > 0)
                        <form action="{{ route('keranjang.add', $produk->id) }}" method="POST" class="d-flex align-items-center gap-3">
                            @csrf
                            <div class="input-group" style="width: 150px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-start-pill" id="minus-btn" style="width: 40px;">-</button>
                                <input type="number" name="jumlah" id="jumlah-produk" value="1" min="1" max="{{ $produk->stok }}" class="form-control text-center quantity-input fw-semibold border-start-0 border-end-0" readonly style="height: 38px; background-color: white;">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-end-pill" id="plus-btn" style="width: 40px;">+</button>
                            </div>
                            <button class="btn btn-primary rounded-pill px-4 py-2 flex-grow-1 fw-bold shadow-sm" type="submit">
                                <i class="fa fa-cart-plus me-2"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @elseif(!Auth::check() && $produk->stok > 0)
                        <div class="alert alert-info text-center rounded-3 shadow-sm"> <i class="fa fa-info-circle me-2"></i> Silakan <a href="{{ route('login') }}" class="alert-link fw-semibold">login</a> untuk menambahkan produk ke keranjang. </div>
                    @elseif(Auth::check() && Auth::user()->role == 'penjual' && Auth::id() == $produk->user_id)
                        <div class="alert alert-secondary text-center rounded-3 shadow-sm"> <i class="fa fa-info-circle me-2"></i> Ini adalah produk yang Anda kelola. <a href="{{ route('produk.edit', $produk->id) }}" class="alert-link fw-semibold">Edit Produk</a> </div>
                    @else
                        <div class="alert alert-warning text-center rounded-3 shadow-sm"> <i class="fa fa-exclamation-triangle me-2"></i> Stok produk habis atau Anda tidak dapat membeli saat ini. </div>
                    @endif
                </div>
            </div>

            <div class="mt-5 pt-4 border-top">
                <ul class="nav nav-pills product-tabs mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi-tab-pane" type="button" role="tab">Deskripsi Produk</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="ulasan-tab" data-bs-toggle="tab" data-bs-target="#ulasan-tab-pane" type="button" role="tab">Ulasan ({{ $produk->reviews->count() }})</button></li>
                </ul>
                <div class="tab-content" id="productTabsContent">
                    <div class="tab-pane fade show active p-4 bg-light rounded-3 shadow-sm" id="deskripsi-tab-pane" role="tabpanel">
                         <p class="text-muted mb-0" style="white-space: pre-wrap;">{{ $produk->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <div class="tab-pane fade p-4 bg-light rounded-3 shadow-sm" id="ulasan-tab-pane" role="tabpanel">
                        @forelse($produk->reviews->sortByDesc('created_at') as $review)
                            <div class="review-item border-bottom pb-3 mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                        {{ strtoupper(substr($review->user->nama ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-0 text-secondary">{{ $review->user->nama ?? 'Pengguna Anonim' }}</h6>
                                        <small class="text-body-secondary">{{ $review->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">{{ $review->komentar }}</p>
                            </div>
                        @empty
                            <div class="alert alert-secondary text-center mb-0 border-0">
                                <i class="far fa-comment-dots me-2 opacity-75"></i> Belum ada ulasan untuk produk ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('jumlah-produk');
    const minusBtn = document.getElementById('minus-btn');
    const plusBtn = document.getElementById('plus-btn');

    if (quantityInput && minusBtn && plusBtn) {
        const maxStok = parseInt(quantityInput.getAttribute('max'));
        const minStok = parseInt(quantityInput.getAttribute('min'));

        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > minStok) { quantityInput.value = currentValue - 1; }
        });

        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxStok) { quantityInput.value = currentValue + 1; }
        });

        quantityInput.addEventListener('change', function() {
            let currentValue = parseInt(quantityInput.value);
            if (isNaN(currentValue) || currentValue < minStok) { quantityInput.value = minStok; }
            else if (currentValue > maxStok) { quantityInput.value = maxStok; }
        });
    }
});

function changeMainImage(newImageSrc, clickedThumbnail) {
    const mainImage = document.getElementById('mainProductImage');
    if(mainImage) { mainImage.src = newImageSrc; }
    const thumbnails = document.querySelectorAll('.product-gallery-thumbnails img');
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    clickedThumbnail.classList.add('active');
}
</script>
@endpush