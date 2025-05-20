@extends('layout.public')
@section('title', 'Detail Produk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Detail Produk</h2>

<div class="card">
    <h3>{{ $produk->nama }}</h3>
    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga,0,',','.') }}</p>
    <p><strong>Stok:</strong> {{ $produk->stok }}</p>
    <p><strong>Deskripsi:</strong><br>{{ $produk->deskripsi }}</p>
    <p><strong>Penjual:</strong> {{ $produk->user->nama }}</p>

    <a class="btn btn-primary btn-sm" href="{{ route('produk.index') }}">Kembali ke Daftar Produk</a>
    @if(in_array($transaksi->status, ['dikirim', 'selesai']))
    <a class="btn btn-primary btn-sm" href="{{ route('transaksi.invoice', $transaksi->id) }}">Cetak Invoice (PDF)</a>
    @endif
    @if(Auth::check() && Auth::user()->role == 'pembeli')
        <a class="btn btn-primary btn-sm" href="{{ route('checkout', $produk->id) }}">Beli Sekarang</a>
    @endif
    @if($transaksi->status == 'selesai' && Auth::id() == $transaksi->user_id)
    <a class="btn btn-primary btn-sm" href="{{ route('review.create', $transaksi->id) }}">Beri Ulasan</a>
    @endif

</div>
@endsection
