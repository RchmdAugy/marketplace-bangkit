
@extends('layout.public')
@section('title', 'Keranjang Belanja')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Keranjang Belanja</h2>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($items->count())
@php
    $grandTotal = $items->sum(function($item) {
        return $item->produk->harga * $item->jumlah;
    });
@endphp
<div class="table-responsive">
    <table class="table table-bordered align-middle shadow-sm">
        <thead class="table-light">
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
                <strong>{{ $item->produk->nama }}</strong>
                @if($item->produk->foto)
                    <div class="mt-2">
                        <img src="{{ asset('foto_produk/'.$item->produk->foto) }}" alt="Foto Produk" style="height:60px;object-fit:cover;" class="rounded">
                    </div>
                @endif
            </td>
            <td>
                <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    @method('PUT')
                    <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" class="form-control form-control-sm" style="width:60px;">
                    <button class="btn btn-sm btn-outline-secondary" type="submit" title="Update"><i class="fa fa-sync"></i></button>
                </form>
            </td>
            <td>Rp {{ number_format($item->produk->harga,0,',','.') }}</td>
            <td>Rp {{ number_format($item->produk->harga * $item->jumlah,0,',','.') }}</td>
            <td>
                <a href="{{ route('keranjang.remove', $item->id) }}" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Grand Total</th>
                <th colspan="2">Rp {{ number_format($grandTotal,0,',','.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="d-flex justify-content-end">
    <form action="{{ route('keranjang.checkout') }}" method="POST">
        @csrf
        <button class="btn btn-primary btn-lg"><i class="fa fa-shopping-cart"></i> Checkout Semua</button>
    </form>
</div>
@else
    <div class="alert alert-info">Keranjang kosong.</div>
@endif
@endsection