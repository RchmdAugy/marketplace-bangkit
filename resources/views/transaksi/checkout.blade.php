@extends('layout.public')
@section('title', 'Checkout Produk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Checkout Produk</h2>

<div class="card">
    <h3>{{ $produk->nama }}</h3>
    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga,0,',','.') }}</p>
    <p><strong>Stok Tersedia:</strong> {{ $produk->stok }}</p>

    <form action="{{ route('checkout.proses', $produk->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Jumlah Beli:</label>
            <input type="number" name="jumlah" min="1" max="{{ $produk->stok }}" required class="form-control">
        </div>
        <button class="btn btn-primary btn-sm" type="submit">Pesan Sekarang</button>
        <a class="btn btn-primary btn-sm" href="{{ route('produk.index') }}">Batal</a>
    </form>
</div>
@endsection
