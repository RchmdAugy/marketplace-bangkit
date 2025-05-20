
@extends('layout.public')
@section('title', 'Riwayat Transaksi')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Riwayat Transaksi Saya</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
@forelse($pesanans as $trx)
    <div class="col-md-6">
        <div class="card shadow border-0 rounded-4 mb-3 h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold text-primary mb-0">#{{ $trx->id }}</h5>
                    <span class="badge 
                        {{ $trx->status == 'selesai' ? 'bg-success' : 
                           ($trx->status == 'dikirim' ? 'bg-info' : 
                           ($trx->status == 'diproses' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                        {{ ucfirst($trx->status) }}
                    </span>
                </div>
                <div class="mb-2 text-muted" style="font-size:0.95rem;">
                    <i class="fa fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d/m/Y H:i') }}
                </div>
                <ul class="mb-3 ps-3">
                    @foreach($trx->details as $detail)
                        <li>
                            <span class="fw-semibold">{{ $detail->produk->nama }}</span>
                            <span class="badge bg-primary ms-1">x{{ $detail->jumlah }}</span>
                            <span class="text-muted ms-2">Rp {{ number_format($detail->harga,0,',','.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="fw-bold fs-6" style="color:#1abc9c;">Total: Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                    <div class="d-flex gap-2 flex-wrap">
                        @if(in_array($trx->status, ['dikirim', 'selesai']))
                            <a class="btn btn-success btn-sm rounded-pill px-3" href="{{ route('transaksi.invoice', $trx->id) }}">
                                <i class="fa fa-file-pdf"></i> Invoice
                            </a>
                        @endif
                        @if($trx->status == 'selesai' && Auth::id() == $trx->user_id)
                            <a class="btn btn-warning btn-sm rounded-pill px-3" href="{{ route('review.create', $trx->id) }}">
                                <i class="fa fa-star"></i> Ulasan
                            </a>
                        @endif
                        <a class="btn btn-outline-primary btn-sm rounded-pill px-3" href="{{ route('transaksi.show', $trx->id) }}">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info text-center shadow-sm rounded-4">
            Belum ada transaksi.
        </div>
    </div>
@endforelse
</div>
@endsection