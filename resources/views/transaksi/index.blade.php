@extends('layout.public')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container py-4">
    <h2 class="mb-5 fw-bold text-center">Riwayat Transaksi Saya</h2>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        @forelse($transaksis as $trx)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-semibold mb-0">#{{ $trx->id }}</h5>
                        <span class="badge {{ $trx->status == 'selesai' ? 'bg-success' : 
                           ($trx->status == 'dikirim' ? 'bg-info' : 
                           ($trx->status == 'diproses' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </div>
                    <div class="mb-2 text-muted small">
                        <i class="fa fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d/m/Y H:i') }}
                    </div>
                    <ul class="mb-3 ps-3 small">
                        @foreach($trx->details as $detail)
                            <li>
                                <strong class="text-dark">{{ $detail->produk->nama }}</strong>
                                <span class="badge bg-primary ms-1">x{{ $detail->jumlah }}</span>
                                <span class="text-muted ms-2">Rp {{ number_format($detail->harga,0,',','.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                        <span class="fw-bold text-success">Total: Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                            @if(in_array($trx->status, ['dikirim', 'selesai']))
                                <a href="{{ route('transaksi.invoice', $trx->id) }}" class="btn btn-success btn-sm rounded-pill px-3">
                                    <i class="fa fa-file-pdf"></i> Invoice
                                </a>
                            @endif
                            @if($trx->status == 'selesai' && Auth::id() == $trx->user_id)
                                <a href="{{ route('review.create', $trx->id) }}" class="btn btn-warning btn-sm rounded-pill px-3">
                                    <i class="fa fa-star"></i> Ulasan
                                </a>
                            @endif
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="fa fa-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center shadow-sm rounded-4 py-4">
                Belum ada transaksi.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
