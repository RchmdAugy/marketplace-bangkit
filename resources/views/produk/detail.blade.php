@extends('layout.public')
@section('title', 'Detail Produk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Detail Produk</h2>

<div class="card">
    <h3>{{ $produk->nama }}</h3>
    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga,0,',','.') }}</p>
    <p><strong>Stok:</strong> {{ $produk->stok }}</p>
    <p><strong>Deskripsi:</strong><br>{{ $produk->deskripsi }}</p>
    <hr>
    <h4>Ulasan Produk</h4>
    @php
    $reviews = $produk->reviews()->with('user')->latest()->get();
    @endphp
    @if($reviews->count() > 0)
        @foreach($reviews as $rev)
            <div style="border:1px solid #ccc; padding:8px; margin-bottom:5px;">
                <strong>{{ $rev->user->nama }}</strong> - Rating: {{ $rev->rating }} ⭐<br>
                {{ $rev->komentar }}<br>
                <small>Ditulis pada {{ $rev->created_at->format('d/m/Y') }}</small>
            </div>
        @endforeach
    @else
        <p>Belum ada ulasan untuk produk ini.</p>
    @endif
    <p><strong>Penjual:</strong> {{ $produk->user->nama }}</p>
    <a class="btn btn-primary btn-sm" href="{{ route('produk.index') }}">Kembali ke Daftar Produk</a>
    @if(Auth::check() && Auth::user()->role == 'pembeli')
        <a class="btn btn-primary btn-sm" href="{{ route('checkout', $produk->id) }}">Beli Sekarang</a>
    @endif
</div>
@endsection
