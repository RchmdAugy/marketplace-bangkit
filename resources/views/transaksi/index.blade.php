@extends('layout.public')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container py-4">
    <h2 class="mb-5 fw-bold text-center" style="color:#1abc9c;">Riwayat Transaksi Saya</h2>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        @forelse($transaksis as $trx)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 transaksi-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-semibold mb-0 text-dark">#{{ $trx->id }}</h5>
                        <span class="badge status-badge {{ $trx->status }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </div>
                    <div class="mb-2 text-muted small">
                        <i class="fa fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d/m/Y H:i') }}
                    </div>
                    <ul class="mb-3 ps-3 small">
                        @foreach($trx->details as $detail)
                            <li>
                                <strong>{{ $detail->produk->nama }}</strong>
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
            <div class="alert alert-info text-center shadow-sm rounded-4">
                Belum ada transaksi.
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    .transaksi-card {
        transition: all 0.3s ease;
    }
    .transaksi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 32px rgba(26,188,156,0.15);
    }

    .status-badge {
        padding: 0.4em 0.7em;
        font-size: 0.85rem;
        border-radius: 50px;
        text-transform: capitalize;
    }
    .status-badge.selesai {
        background-color: #2ecc71;
        color: #fff;
    }
    .status-badge.dikirim {
        background-color: #3498db;
        color: #fff;
    }
    .status-badge.diproses {
        background-color: #f1c40f;
        color: #000;
    }
    .status-badge.pending, .status-badge.menunggu {
        background-color: #bdc3c7;
        color: #000;
    }

    .btn-outline-primary {
        border: 2px solid #1abc9c;
        color: #1abc9c !important;
        transition: 0.3s;
    }
    .btn-outline-primary:hover {
        background-color: #1abc9c !important;
        color: white !important;
    }

    .btn-success {
        background-color: #1abc9c;
        border: none;
    }
    .btn-success:hover {
        background-color: #16a085;
    }
</style>
@endsection
