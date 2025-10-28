@extends('layout.public')
@section('title', 'Pesanan Masuk')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center text-secondary">Pesanan Masuk</h2>
    
    @if(session('success'))
        {{-- Menambahkan rounded-4 agar konsisten --}}
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        {{-- Menambahkan rounded-4 agar konsisten --}}
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- =============================================== --}}
    {{-- ==== TAMPILAN DESKTOP (TABLE) - LG ke atas ==== --}}
    {{-- =============================================== --}}
    <div class="card shadow-sm border-0 rounded-4 d-none d-lg-block">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th style="width: 220px;">Ubah Status</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pesanans as $trx)
                        <tr>
                            <td class="fw-medium">#{{ $trx->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $trx->user->foto_profil ? asset('foto_profil/'.$trx->user->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($trx->user->nama).'&background=E2E8F0&color=334155&size=64' }}" 
                                         class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;" alt="Foto">
                                    <span class="fw-medium">{{ $trx->user->nama }}</span>
                                </div>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                            <td>
                                <span class="badge fs-6 text-capitalize @switch($trx->status)
                                    @case('selesai') bg-success-subtle text-success-emphasis @break
                                    @case('dikirim') bg-info-subtle text-info-emphasis @break
                                    @case('diproses') bg-warning-subtle text-warning-emphasis @break
                                    @default bg-secondary-subtle text-secondary-emphasis
                                @endswitch">{{ str_replace('_', ' ', $trx->status) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('pesanan.updateStatus', $trx->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="menunggu pembayaran" @if($trx->status=='menunggu pembayaran') selected @endif>Menunggu Pembayaran</option>
                                        <option value="diproses" @if($trx->status=='diproses') selected @endif>Diproses</option>
                                        <option value="dikirim" @if($trx->status=='dikirim') selected @endif>Dikirim</option>
                                        <option value="selesai" @if($trx->status=='selesai') selected @endif>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-center">
                                {{-- Mengganti ikon dengan tombol teks agar konsisten dengan mobile --}}
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Lihat Detail">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa fa-inbox fa-3x mb-3"></i>
                                <h5 class="fw-medium">Belum ada pesanan yang masuk.</h5>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- ==== TAMPILAN MOBILE (CARD) - MD ke bawah ===== --}}
    {{-- =============================================== --}}
    <div class="d-block d-lg-none">
        @forelse($pesanans as $trx)
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-primary mb-0">Pesanan #{{ $trx->id }}</h6>
                    <small class="text-muted">{{ $trx->created_at->format('d M Y') }}</small>
                </div>
                
                {{-- Merapikan tata letak card-body --}}
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pembeli:</span>
                        <span class="fw-medium text-dark">{{ $trx->user->nama }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total:</span>
                        <span class="fw-bold text-primary fs-5">Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Status:</span>
                        <span class="badge fs-6 text-capitalize @switch($trx->status)
                            @case('selesai') bg-success-subtle text-success-emphasis @break
                            @case('dikirim') bg-info-subtle text-info-emphasis @break
                            @case('diproses') bg-warning-subtle text-warning-emphasis @break
                            @default bg-secondary-subtle text-secondary-emphasis
                        @endswitch">{{ str_replace('_', ' ', $trx->status) }}</span>
                    </div>
                </div>

                <div class="card-footer bg-white p-3 border-0">
                    <div class="row g-2 align-items-center">
                        <div class="col-7">
                            <form action="{{ route('pesanan.updateStatus', $trx->id) }}" method="POST">
                                @csrf
                                {{-- 
                                  =================================================
                                  == PERBAIKAN BUG: Dropdown mobile disamakan    ==
                                  == dengan desktop agar status 'selected' muncul. ==
                                  =================================================
                                --}}
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="menunggu pembayaran" @if($trx->status=='menunggu pembayaran') selected @endif>Menunggu Pembayaran</option>
                                    <option value="diproses" @if($trx->status=='diproses') selected @endif>Diproses</option>
                                    <option value="dikirim" @if($trx->status=='dikirim') selected @endif>Dikirim</option>
                                    <option value="selesai" @if($trx->status=='selesai') selected @endif>Selesai</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-5 d-grid">
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Mempercantik tampilan kosong --}}
            <div class="card border-0 bg-light rounded-4">
                <div class="card-body text-center text-muted py-5">
                    <i class="fa fa-inbox fa-4x mb-4"></i>
                    <h4 class="fw-semibold">Belum Ada Pesanan</h4>
                    <p class="mb-0">Belum ada pesanan yang masuk ke toko Anda.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection