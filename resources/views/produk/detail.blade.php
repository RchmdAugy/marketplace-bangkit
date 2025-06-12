@extends('layout.public')
@section('title', 'Detail Produk')

@section('content')
<h2 class="mb-4 fw-bold text-center">Detail Produk</h2>
<div class="row justify-content-center py-4">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <div class="row">
                    @if($produk->foto)
                    <div class="col-md-5 mb-3 mb-md-0">
                        <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" class="img-fluid rounded-3 w-100 shadow-sm" style="object-fit:cover;max-height:300px;">
                    </div>
                    @endif
                    <div class="{{ $produk->foto ? 'col-md-7' : 'col-12' }}">
                        <h3 class="card-title mb-3 fw-bold">{{ $produk->nama }}</h3>
                        <div class="mb-2">
                            <span class="badge bg-primary fs-6 me-2">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                            <span class="badge bg-secondary fs-6">Stok: {{ $produk->stok }}</span>
                        </div>
                        <p class="card-text mt-3 text-muted"><strong>Deskripsi:</strong><br>{{ $produk->deskripsi }}</p>
                        <p class="mt-3"><strong>Penjual:</strong> <span class="fw-semibold text-primary">{{ $produk->user->nama }}</span></p>
                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <a class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2" href="{{ route('produk.index') }}"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
                            @if(Auth::check() && Auth::user()->role == 'pembeli')
                                <form action="{{ route('keranjang.add', $produk->id) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                    @csrf
                                    <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" class="form-control form-control-sm rounded-pill text-center" style="width:80px;">
                                    <button class="btn btn-primary rounded-pill px-4 fw-bold py-2"><i class="fa fa-cart-plus me-2"></i> Tambah ke Keranjang</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h4 class="mb-3 fw-bold">Ulasan Produk ({{ $produk->reviews->count() }})</h4>

                @forelse($produk->reviews as $review)
                <div class="card mb-3 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 fw-semibold text-dark">Oleh: {{ $review->user->nama ?? 'Pengguna Tidak Dikenal' }}</h6>
                        <div class="mb-2">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $review->rating)
                                    <i class="fa fa-star text-warning"></i>
                                @else
                                    <i class="fa fa-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="card-text text-muted">{{ $review->komentar }}</p>
                        <small class="text-secondary">{{ $review->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                @empty
                <div class="alert alert-info text-center shadow-sm rounded-4 py-3">
                    <i class="fa fa-info-circle me-2"></i> Belum ada ulasan untuk produk ini.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection