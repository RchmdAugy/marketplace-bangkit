@extends('layout.public')
@section('title', 'Detail Transaksi #'.$transaksi->id)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-light"><i class="fa fa-arrow-left me-2"></i>Kembali</a>
                @if(in_array($transaksi->status, ['dikirim', 'selesai']))
                    <a class="btn btn-outline-success rounded-pill px-3" href="{{ route('transaksi.invoice', $transaksi->id) }}"><i class="fa fa-file-pdf me-2"></i> Cetak Invoice</a>
                @endif
            </div>
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 p-4 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0">Detail Transaksi</h4>
                            <p class="text-muted mb-0">#INV{{ $transaksi->id }}</p>
                        </div>
                        <span class="badge fs-6 rounded-pill text-capitalize @switch($transaksi->status)
                            @case('selesai') bg-success-subtle text-success-emphasis @break
                            @case('dikirim') bg-info-subtle text-info-emphasis @break
                            @case('diproses') bg-warning-subtle text-warning-emphasis @break
                            @default bg-secondary-subtle text-secondary-emphasis
                        @endswitch">{{ str_replace('_', ' ', $transaksi->status) }}</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Tanggal Transaksi</strong>
                            <span>{{ $transaksi->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Pembeli</strong>
                            <span>{{ $transaksi->user->nama }}</span>
                        </div>
                    </div>
                    <strong class="text-muted d-block">Alamat Pengiriman</strong>
                    <p>{{ $transaksi->alamat_pengiriman }}</p>
                    <hr>
                    <h5 class="fw-semibold mb-3">Produk yang Dipesan</h5>
                    <ul class="list-group list-group-flush">
                    @foreach($transaksi->details as $detail)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</strong>
                                <small class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</small>
                            </div>
                            <span class="fw-medium">Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>

                    @if($transaksi->status == 'menunggu pembayaran' && Auth::id() == $transaksi->user_id && $transaksi->snap_token)
                        <div class="d-grid mt-4">
                            <a href="{{ route('transaksi.pembayaran', $transaksi->id) }}" class="btn btn-primary rounded-pill btn-lg"><i class="fa fa-credit-card me-2"></i> Lanjutkan Pembayaran</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection