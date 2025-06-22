@extends('layout.public')
@section('title', 'Beri Ulasan')

@push('css')
<style>
    /* CSS untuk rating bintang interaktif */
    .star-rating {
        display: flex;
        flex-direction: row-reverse; /* Bintang dari kanan ke kiri */
        justify-content: flex-end;
        font-size: 2rem;
        color: #ddd;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        cursor: pointer;
        transition: color 0.2s ease;
    }
    /* Saat hover, warnai bintang di bawahnya dan bintang itu sendiri */
    .star-rating:not(:hover) input:checked ~ label,
    .star-rating:hover input ~ label:hover,
    .star-rating:hover input ~ label:hover ~ label {
        color: #ffc107; /* Warna kuning bintang */
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Beri Ulasan untuk Pesanan #{{ $transaksi->id }}</h2>
                <p class="text-muted">Bagikan pengalaman Anda tentang produk yang telah Anda beli.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @foreach($transaksi->details as $detail)
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('foto_produk/'.$detail->produk->foto) }}" class="rounded-3 me-4" style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $detail->produk->nama }}">
                        <div>
                            <h5 class="fw-semibold mb-0">{{ $detail->produk->nama }}</h5>
                            <small class="text-muted">Dibeli pada {{ $transaksi->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                    
                    <hr>

                    {{-- Cek apakah produk ini sudah direview --}}
                    @php
                        $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                                            ->where('transaksi_id', $transaksi->id)
                                                            ->where('produk_id', $detail->produk->id)
                                                            ->first();
                    @endphp

                    @if($existingReview)
                        <div class="alert alert-light text-center">
                            <i class="fa fa-check-circle text-success me-2"></i>Anda sudah memberikan ulasan untuk produk ini.
                        </div>
                    @else
                        <form action="{{ route('review.store', $transaksi->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $detail->produk->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Rating Anda:</label>
                                <div class="star-rating">
                                    <input type="radio" id="5-stars-{{$detail->produk->id}}" name="rating" value="5" required/><label for="5-stars-{{$detail->produk->id}}"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="4-stars-{{$detail->produk->id}}" name="rating" value="4" required/><label for="4-stars-{{$detail->produk->id}}"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="3-stars-{{$detail->produk->id}}" name="rating" value="3" required/><label for="3-stars-{{$detail->produk->id}}"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="2-stars-{{$detail->produk->id}}" name="rating" value="2" required/><label for="2-stars-{{$detail->produk->id}}"><i class="fa fa-star"></i></label>
                                    <input type="radio" id="1-star-{{$detail->produk->id}}" name="rating" value="1" required/><label for="1-star-{{$detail->produk->id}}"><i class="fa fa-star"></i></label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="komentar-{{$detail->produk->id}}" class="form-label fw-medium">Komentar Anda:</label>
                                <textarea name="komentar" id="komentar-{{$detail->produk->id}}" class="form-control" rows="3" required placeholder="Tuliskan pengalaman Anda menggunakan produk ini..."></textarea>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary rounded-pill px-4" type="submit">
                                    <i class="fa fa-paper-plane me-2"></i> Kirim Ulasan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
            <div class="text-center mt-4">
                 <a class="btn btn-outline-secondary rounded-pill px-5" href="{{ route('transaksi.index') }}">Kembali ke Riwayat Transaksi</a>
            </div>
        </div>
    </div>
</div>
@endsection