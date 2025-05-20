
@extends('layout.public')
@section('title', 'Detail Transaksi')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Detail Transaksi</h2>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-body">
                <h5 class="mb-3 fw-bold text-primary">Transaksi #{{ $transaksi->id }} | {{ $transaksi->created_at->format('d/m/Y H:i') }}</h5>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $transaksi->status == 'selesai' ? 'success' : ($transaksi->status == 'dikirim' ? 'info' : ($transaksi->status == 'diproses' ? 'warning' : 'secondary')) }}">
                        {{ ucfirst($transaksi->status) }}
                    </span>
                </p>
                <table class="table table-bordered align-middle shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $detail)
                        <tr>
                            <td>
                                <strong>{{ $detail->produk->nama ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $detail->produk->deskripsi ?? '' }}</small>
                            </td>
                            <td>Rp {{ number_format($detail->harga,0,',','.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->harga * $detail->jumlah,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="fw-bold">Total Harga: <span style="color:#1abc9c;">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span></p>
                <p><strong>Pembeli:</strong> {{ $transaksi->user->nama }}</p>
                <p><strong>Tanggal Pesan:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a class="btn btn-outline-primary btn-sm rounded-pill" href="{{ route('transaksi.index') }}"><i class="fa fa-arrow-left"></i> Kembali ke Riwayat</a>
                    @if(in_array($transaksi->status, ['dikirim', 'selesai']))
                        <a class="btn btn-success btn-sm rounded-pill" href="{{ route('transaksi.invoice', $transaksi->id) }}"><i class="fa fa-file-pdf"></i> Cetak Invoice</a>
                    @endif
                    @if(Auth::check() && Auth::user()->role == 'pembeli')
                        <a class="btn btn-primary btn-sm rounded-pill" href="{{ route('keranjang.index') }}"><i class="fa fa-shopping-cart"></i> Beli Lagi</a>
                    @endif
                    @if($transaksi->status == 'selesai' && Auth::id() == $transaksi->user_id)
                        <a class="btn btn-warning btn-sm rounded-pill" href="{{ route('review.create', $transaksi->id) }}"><i class="fa fa-star"></i> Beri Ulasan</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection