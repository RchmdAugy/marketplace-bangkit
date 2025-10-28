@extends('layout.public')
@section('title', 'Riwayat Transaksi Saya') {{-- Judul lebih deskriptif --}}

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-secondary mb-3">Riwayat Transaksi Saya</h1> {{-- Judul utama lebih menonjol --}}
        <p class="lead text-muted">Lihat semua aktivitas belanja Anda di sini.</p> {{-- Tambah deskripsi --}}
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($transaksis as $trx)
        <div class="col-md-6 col-lg-6"> {{-- Gunakan col-md-6 untuk responsifitas --}}
            <div class="card border-0 shadow-lg rounded-4 h-100"> {{-- Shadow lebih kuat --}}
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold text-primary mb-1">#INV{{ $trx->id }}</h5> {{-- ID invoice lebih menonjol --}}
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d F Y, H:i') }}</small> {{-- Ikon calendar lebih modern --}}
                        </div>
                        <span class="badge fs-6 px-3 py-2 rounded-pill text-capitalize 
                            @switch($trx->status)
                                @case('selesai') bg-success text-white @break
                                @case('dikirim') bg-info text-white @break
                                @case('diproses') bg-warning text-dark @break
                                @case('menunggu pembayaran') bg-danger text-white @break {{-- Tambah badge untuk status ini --}}
                                @default bg-secondary text-white
                            @endswitch">
                            <i class="fas fa-circle-dot me-2" style="font-size: 0.7em;"></i> {{ str_replace('_', ' ', $trx->status) }}
                        </span>
                    </div>
                    <hr class="my-3">
                    <h6 class="fw-semibold mb-3 text-secondary">Produk Pesanan</h6>
                    <ul class="list-unstyled mb-3 flex-grow-1"> {{-- flex-grow-1 agar card-body bisa expand --}}
                        @foreach($trx->details as $detail)
                            <li class="d-flex align-items-center mb-2">
                                @if($detail->produk && $detail->produk->foto)
                                    <img src="{{ asset('foto_produk/'.$detail->produk->foto) }}" class="rounded-2 me-3" style="width:60px; height:60px; object-fit:cover;" alt="{{ $detail->produk->nama }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light rounded-2 me-3" style="width:60px; height:60px;"><i class="fas fa-image text-muted fs-5"></i></div>
                                @endif
                                <div>
                                    <strong class="text-dark">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</strong>
                                    <div class="text-muted small">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga,0,',','.') }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-auto pt-3 border-top"> {{-- mt-auto agar footer selalu di bawah --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Total Belanja</span>
                            <span class="fw-bold fs-5 text-primary">Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-end"> {{-- flex-wrap dan gap-2 untuk responsifitas tombol --}}
                            @if($trx->status == 'menunggu pembayaran' && $trx->snap_token)
                                <a href="{{ route('transaksi.pembayaran', $trx->id) }}" class="btn btn-sm btn-primary rounded-pill px-3"><i class="fas fa-credit-card me-1"></i> Bayar</a>
                            @endif
                            @if(in_array($trx->status, ['dikirim', 'selesai']))
                                <a href="{{ route('transaksi.invoice', $trx->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="fas fa-file-invoice me-1"></i> Invoice</a>
                            @endif
                            {{-- Hanya tampilkan tombol Ulasan jika status sudah selesai dan belum diulas --}}
                            @if($trx->status == 'selesai' && !$trx->is_reviewed) {{-- Gunakan accessor yang baru kita buat --}}
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
            <div class="card border-0 shadow-lg rounded-4 p-5 text-center my-5"> {{-- Card untuk pesan empty state --}}
                <div class="card-body">
                    <i class="fas fa-box-open text-muted mb-4" style="font-size: 4rem;"></i> {{-- Ikon lebih besar --}}
                    <h4 class="fw-bold text-secondary mb-3">Anda belum memiliki riwayat transaksi.</h4>
                    <p class="text-muted mb-4">Mulai jelajahi produk-produk menarik kami dan buat pesanan pertama Anda!</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold">Mulai Belanja Sekarang</a>
                </div>
            </div>
        </div>
        @endforelse

        {{-- Jika Anda memiliki pagination, tempatkan di sini --}}
        {{-- <div class="col-12 mt-4 d-flex justify-content-center">
            {{ $transaksis->links() }}
        </div> --}}
    </div>
</div>
@endsection