@extends('layout.public')
@section('title', 'Keranjang Belanja')

@section('content')
<h2 class="border-bottom pb-2 mb-3 fw-bold">Keranjang Belanja</h2>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($items->count())
@php
    $grandTotal = $items->sum(function($item) {
        return $item->produk->harga * $item->jumlah;
    });
@endphp
<div class="table-responsive">
    <table class="table table-hover align-middle shadow-sm rounded-4 overflow-hidden">
        <thead class="table-primary">
            <tr>
                <th>Produk</th>
                <th style="width:160px;">Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th style="width:100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('foto_produk/' . $item->produk->foto) }}" alt="{{ $item->produk->nama }}" class="img-thumbnail me-3 rounded" style="width:80px;height:80px;object-fit:cover;">
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">{{ $item->produk->nama }}</h6>
                            <small class="text-muted">{{ Str::limit($item->produk->deskripsi, 50) }}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" class="form-control form-control-sm me-2" style="width:70px;">
                        <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-sync-alt"></i></button>
                    </form>
                </td>
                <td>Rp {{ number_format($item->produk->harga,0,',','.') }}</td>
                <td>Rp {{ number_format($item->produk->harga * $item->jumlah,0,',','.') }}</td>
                <td>
                    <a href="{{ route('keranjang.remove', $item->id) }}" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus item ini?')">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<form action="{{ route('keranjang.checkout') }}" method="POST" class="mt-4" id="checkoutForm">
    @csrf
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap Pengiriman</label>
            <textarea name="alamat" id="alamat" class="form-control rounded-3 p-3" rows="4" required>{{ old('alamat') }}</textarea>
        </div>
    </div>
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="card-title fw-bold text-primary mb-3">Ringkasan Biaya</h5>
            <div class="d-flex justify-content-between mb-2 fs-5">
                <span>Subtotal Produk:</span>
                <span class="fw-semibold">Rp {{ number_format($grandTotal,0,',','.') }}</span>
            </div>
            <hr class="my-3">
            <div class="d-flex justify-content-between fs-4 fw-bold">
                <span>Total Bayar:</span>
                <span class="text-success">Rp {{ number_format($grandTotal,0,',','.') }}</span>
            </div>
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold">
            <i class="fa fa-shopping-cart me-2"></i> Checkout Sekarang
        </button>
    </div>
</form>
@else
    <div class="alert alert-info text-center shadow-sm rounded-4 py-4">
        <i class="fa fa-info-circle me-2"></i> Keranjang Anda kosong. Yuk, <a href="{{ route('produk.index') }}" class="alert-link">cari produk menarik</a>!
    </div>
@endif
@endsection
