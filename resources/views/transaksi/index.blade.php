@extends('layout.public')
@section('title', 'Riwayat Transaksi Saya')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-secondary mb-3">Riwayat Transaksi Saya</h1>
        <p class="lead text-muted">Lihat semua aktivitas belanja Anda di sini.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
            <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="row g-4">
        @forelse($transaksis as $trx)
        <div class="col-md-6 col-lg-6 d-flex"> {{-- Tambah d-flex --}}
            <div class="card border-0 shadow-lg rounded-4 h-100 w-100"> {{-- Tambah w-100 --}}
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold text-primary mb-1">#INV{{ $trx->id }}</h5>
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d F Y, H:i') }}</small>
                        </div>

                        {{-- =============================================== --}}
                        {{-- ==  WARNA BADGE DISESUAIKAN DI SINI         == --}}
                        {{-- =============================================== --}}
                        <span class="badge fs-6 px-3 py-2 rounded-pill text-capitalize
                            @switch($trx->status)
                                @case('selesai') bg-success text-white @break
                                @case('dikirim') bg-info text-white @break
                                @case('diproses') bg-success text-white @break {{-- Sama dengan selesai --}}
                                @case('menunggu pembayaran') bg-warning text-dark @break
                                @case('dibatalkan') bg-danger text-white @break
                                @case('pending') bg-secondary text-white @break
                                @default bg-secondary text-white
                            @endswitch">

                            @switch($trx->status)
                                @case('selesai') <i class="fas fa-check-circle me-1"></i> @break
                                @case('dikirim') <i class="fas fa-truck me-1"></i> @break
                                @case('diproses') <i class="fas fa-sync-alt fa-spin me-1"></i> @break
                                @case('menunggu pembayaran') <i class="fas fa-hourglass-half me-1"></i> @break
                                @case('dibatalkan') <i class="fas fa-times-circle me-1"></i> @break
                                @default <i class="fas fa-circle-dot me-1" style="font-size: 0.7em;"></i>
                            @endswitch

                            {{ str_replace('_', ' ', $trx->status) }}
                        </span>
                        {{-- =============================================== --}}
                        {{-- ==  AKHIR PENYESUAIAN WARNA BADGE          == --}}
                        {{-- =============================================== --}}
                    </div>
                    <hr class="my-3">
                    <h6 class="fw-semibold mb-3 text-secondary">Produk Pesanan</h6>
                    <ul class="list-unstyled mb-3 flex-grow-1">
                        @foreach($trx->details as $detail)
                            <li class="d-flex align-items-center mb-2">
                                @php
                                    $imagePath = null;
                                    if ($detail->produk) {
                                        if ($detail->produk->foto && file_exists(public_path('foto_produk/' . $detail->produk->foto))) {
                                            $imagePath = asset('foto_produk/' . $detail->produk->foto);
                                        } elseif ($detail->produk->images->first() && file_exists(public_path('foto_produk_gallery/' . $detail->produk->images->first()->image_path))) {
                                            $imagePath = asset('foto_produk_gallery/' . $detail->produk->images->first()->image_path);
                                        }
                                    }
                                @endphp

                                @if($imagePath)
                                    <img src="{{ $imagePath }}" class="rounded-2 me-3 shadow-sm" style="width:60px; height:60px; object-fit:cover;" alt="{{ $detail->produk->nama ?? 'Produk' }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light rounded-2 me-3 border" style="width:60px; height:60px;"><i class="fas fa-image text-muted fs-5 opacity-50"></i></div>
                                @endif
                                <div>
                                    <strong class="text-dark">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</strong>
                                    <div class="text-muted small">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga,0,',','.') }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Total Belanja</span>
                            <span class="fw-bold fs-5 text-primary">Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            @if($trx->status == 'menunggu pembayaran' && $trx->snap_token)
                                <a href="{{ route('transaksi.pembayaran', $trx->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm"><i class="fas fa-credit-card me-1"></i> Bayar Sekarang</a>
                            @endif
                            @if(in_array($trx->status, ['diproses', 'dikirim', 'selesai']))
                                <a href="{{ route('transaksi.invoice', $trx->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="fas fa-file-invoice me-1"></i> Invoice</a>
                            @endif
                            @if($trx->status == 'selesai' && !$trx->is_reviewed)
                                <a href="{{ route('review.create', $trx->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="fas fa-star me-1"></i> Beri Ulasan</a>
                            @endif
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3"><i class="fas fa-info-circle me-1"></i> Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 p-5 text-center my-5 bg-light">
                <div class="card-body">
                    <i class="fas fa-box-open text-muted mb-4 opacity-50" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold text-secondary mb-3">Anda belum memiliki riwayat transaksi.</h4>
                    <p class="text-muted mb-4">Mulai jelajahi produk-produk menarik kami dan buat pesanan pertama Anda!</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">Mulai Belanja Sekarang</a>
                </div>
            </div>
        </div>
        @endforelse

    </div>
</div>
@endsection