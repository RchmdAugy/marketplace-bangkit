@extends('layout.public')
@section('title', 'Riwayat Transaksi')

@section('content')
<h2 class="mb-4 fw-bold text-center border-bottom pb-2">Riwayat Transaksi Saya</h2>

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
                    <h5 class="fw-bold mb-0">#{{ $trx->id }}</h5>
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
                    <span class="fw-bold fs-6 text-success">Total: Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
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
                        @if(Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->role == 'penjual') && $trx->status != 'selesai')
                        <form action="{{ route('pesanan.updateStatus', $trx->id) }}" method="POST" class="d-inline-block ms-2">
                            @csrf
                            <select name="status" class="form-select form-select-sm d-inline w-auto" style="min-width:120px;display:inline-block;" onchange="this.form.submit()">
                                <option value="menunggu pembayaran" @if($trx->status=='menunggu pembayaran') selected @endif>Menunggu</option>
                                <option value="diproses" @if($trx->status=='diproses') selected @endif>Diproses</option>
                                <option value="dikirim" @if($trx->status=='dikirim') selected @endif>Dikirim</option>
                                <option value="selesai" @if($trx->status=='selesai') selected @endif>Selesai</option>
                            </select>
                        </form>
                        @endif
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