@extends('layout.public')
@section('title', 'Riwayat Transaksi')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Riwayat Transaksi Saya</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transaksis as $trx)
        <tr>
            <td>{{ $trx->produk->nama }}</td>
            <td>{{ $trx->jumlah }}</td>
            <td>Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
            <td>{{ ucfirst($trx->status) }}</td>
            <td>
                <a class="btn btn-primary btn-sm" href="{{ route('transaksi.show', $trx->id) }}"><i class="fa fa-eye"></i> Detail</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
