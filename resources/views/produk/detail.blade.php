
@extends('layout.public')
@section('title', 'Detail Produk')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Detail Produk</h2>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="row">
                    @if($produk->foto)
                    <div class="col-md-5 mb-3 mb-md-0">
                        <img src="{{ asset('foto_produk/'.$produk->foto) }}" alt="Foto Produk" class="img-fluid rounded w-100" style="object-fit:cover;max-height:300px;">
                    </div>
                    @endif
                    <div class="{{ $produk->foto ? 'col-md-7' : 'col-12' }}">
                        <h3 class="card-title mb-3 fw-bold text-primary">{{ $produk->nama }}</h3>
                        <div class="mb-2">
                            <span class="badge bg-success fs-6">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                            <span class="badge bg-secondary ms-2">Stok: {{ $produk->stok }}</span>
                        </div>
                        <p class="card-text mt-3"><strong>Deskripsi:</strong><br>{{ $produk->deskripsi }}</p>
                        <p class="mt-3"><strong>Penjual:</strong> {{ $produk->user->nama }}</p>
                        <div class="d-flex gap-2 mt-4">
                            <a class="btn btn-outline-primary rounded-pill px-4" href="{{ route('produk.index') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
                            @if(Auth::check() && Auth::user()->role == 'pembeli')
                                <form action="{{ route('keranjang.add', $produk->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" style="width:70px;">
                                    <button class="btn btn-warning rounded-pill px-4"><i class="fa fa-cart-plus"></i> Tambah ke Keranjang</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection