@extends('layout.public')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">Riwayat Transaksi Saya</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        @forelse($transaksis as $trx)
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="fw-semibold mb-1">Pesanan #{{ $trx->id }}</h5>
                            <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <span class="badge fs-6 rounded-pill text-capitalize
                            @switch($trx->status)
                                @case('selesai') bg-success-subtle text-success-emphasis @break
                                @case('dikirim') bg-info-subtle text-info-emphasis @break
                                @case('diproses') bg-warning-subtle text-warning-emphasis @break
                                @default bg-secondary-subtle text-secondary-emphasis
                            @endswitch">
                            {{ str_replace('_', ' ', $trx->status) }}
                        </span>
                    </div>
                    <hr>
                    <ul class="list-unstyled mb-3">
                        @foreach($trx->details as $detail)
                            <li class="d-flex align-items-center mb-2">
                                <img src="{{ asset('foto_produk/'.$detail->produk->foto) }}" class="rounded-2 me-3" style="width:50px; height:50px; object-fit:cover;">
                                <div>
                                    <strong class="text-dark">{{ $detail->produk->nama }}</strong>
                                    <div class="text-muted small">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga,0,',','.') }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Belanja</span>
                            <span class="fw-bold fs-5 text-primary">Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                             @if($trx->status == 'menunggu pembayaran' && $trx->snap_token)
                                <a href="{{ route('transaksi.pembayaran', $trx->id) }}" class="btn btn-sm btn-primary rounded-pill">Bayar</a>
                            @endif
                            @if(in_array($trx->status, ['dikirim', 'selesai']))
                                <a href="{{ route('transaksi.invoice', $trx->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">Invoice</a>
                            @endif
                            @if($trx->status == 'selesai')
                                <a href="{{ route('review.create', $trx->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">Ulasan</a>
                            @endif
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light text-center py-5">
                <h4>Anda belum memiliki riwayat transaksi.</h4>
                <a href="{{ route('produk.index') }}" class="btn btn-primary rounded-pill px-4 mt-3">Mulai Belanja</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection