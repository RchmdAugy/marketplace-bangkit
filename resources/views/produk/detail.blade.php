@extends('layout.public')
@section('title', $produk->nama)

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-lg-5">
            <div class="row gx-lg-5">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    @if($produk->foto)
                        <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" class="img-fluid rounded-4 shadow w-100">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-4 w-100" style="height: 400px;">
                            <i class="fa fa-image fa-5x text-secondary"></i>
                        </div>
                    @endif
                </div>

                <div class="col-lg-7">
                    <h1 class="display-6 fw-bold mb-3">{{ $produk->nama }}</h1>
                    <div class="d-flex align-items-center mb-3">
                        <span class="text-muted me-3">Penjual: 
                            <a href="{{ route('toko.show', $produk->user->id) }}" class="text-decoration-none fw-medium text-primary">
                                {{ $produk->user->nama_toko ?? $produk->user->nama }}
                            </a>
                        </span>
                        <span class="text-muted"><i class="fa fa-star text-warning me-1"></i> {{ number_format($produk->reviews->avg('rating'), 1) }} ({{ $produk->reviews->count() }} ulasan)</span>
                    </div>
                    <p class="fs-3 fw-bold text-primary mb-4">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                    
                    <div class="d-flex align-items-center mb-4">
                        <span class="text-muted fw-medium me-3">Stok: {{ $produk->stok }}</span>
                    </div>

                    @if(Auth::check() && Auth::user()->role == 'pembeli' && $produk->stok > 0)
                        <form action="{{ route('keranjang.add', $produk->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <label for="jumlah" class="form-label mb-0 fw-medium">Jumlah:</label>
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" class="form-control text-center" style="width: 80px;">
                            <button class="btn btn-primary rounded-pill px-4 py-2 flex-grow-1"><i class="fa fa-cart-plus me-2"></i> Tambah ke Keranjang</button>
                        </form>
                    @elseif($produk->stok <= 0)
                        <div class="alert alert-warning">Stok produk habis.</div>
                    @endif
                </div>
            </div>

            <div class="mt-5">
                <ul class="nav nav-tabs nav-pills flex-nowrap" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi-tab-pane" type="button" role="tab">Deskripsi Produk</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ulasan-tab" data-bs-toggle="tab" data-bs-target="#ulasan-tab-pane" type="button" role="tab">Ulasan ({{ $produk->reviews->count() }})</button>
                    </li>
                </ul>
                <div class="tab-content pt-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="deskripsi-tab-pane" role="tabpanel">
                        <p class="text-muted" style="white-space: pre-wrap;">{{ $produk->deskripsi }}</p>
                    </div>
                    <div class="tab-pane fade" id="ulasan-tab-pane" role="tabpanel">
                        @forelse($produk->reviews as $review)
                        <div class="d-flex gap-3 mb-4">
                            <i class="fa fa-user-circle fs-2 text-secondary"></i>
                            <div>
                                <h6 class="fw-semibold mb-0">{{ $review->user->nama ?? 'Pengguna' }}</h6>
                                <div class="mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-muted mb-1">{{ $review->komentar }}</p>
                                <small class="text-body-secondary">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-light text-center">Belum ada ulasan untuk produk ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection