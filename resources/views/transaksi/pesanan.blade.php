@extends('layout.public')
@section('title', 'Pesanan Masuk')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Pesanan Masuk</h2>

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
            <th>Pembeli</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Tanggal Pesan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pesanans as $trx)
        <tr>
            <td>{{ $trx->produk->nama }}</td>
            <td>{{ $trx->user->nama }}</td>
            <td>{{ $trx->jumlah }}</td>
            <td>Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
            <td>
                <form action="{{ route('pesanan.updateStatus', $trx->id) }}" method="POST">
                    @csrf
                    <select name="status" class="form-select form-select-sm">
                        <option value="menunggu pembayaran" {{ $trx->status == 'menunggu pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="diproses" {{ $trx->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dikirim" {{ $trx->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="selesai" {{ $trx->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <button class="btn btn-primary btn-sm mt-1"><i class="fa fa-sync"></i> Update</button>
                </form>
            </td>
            <td>{{ $trx->created_at->format('d/m/Y') }}</td>
            <td>
                <a class="btn btn-primary btn-sm" href="{{ route('transaksi.show', $trx->id) }}"><i class="fa fa-eye"></i> Detail</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
