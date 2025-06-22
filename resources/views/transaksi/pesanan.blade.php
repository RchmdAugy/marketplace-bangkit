@extends('layout.public')
@section('title', 'Pesanan Masuk')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center">Pesanan Masuk</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $errors->first() }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
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
                            <th class="text-center" style="width: 200px;">Ubah Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pesanans as $trx)
                        <tr>
                            <td class="fw-medium">#{{ $trx->id }}</td>
                            <td>{{ $trx->user->nama }}</td>
                            <td class="fw-medium">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                            <td><span class="badge text-capitalize @switch($trx->status)
                                @case('selesai') bg-success-subtle text-success-emphasis @break
                                @case('dikirim') bg-info-subtle text-info-emphasis @break
                                @case('diproses') bg-warning-subtle text-warning-emphasis @break
                                @default bg-secondary-subtle text-secondary-emphasis
                            @endswitch">{{ str_replace('_', ' ', $trx->status) }}</span></td>
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
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">Belum ada pesanan yang masuk.</td></tr>
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
                    <h6 class="fw-bold mb-0">Pesanan #{{ $trx->id }}</h6>
                    <span class="badge text-capitalize @switch($trx->status)
                        @case('selesai') bg-success-subtle text-success-emphasis @break
                        @case('dikirim') bg-info-subtle text-info-emphasis @break
                        @case('diproses') bg-warning-subtle text-warning-emphasis @break
                        @default bg-secondary-subtle text-secondary-emphasis
                    @endswitch">{{ str_replace('_', ' ', $trx->status) }}</span>
                </div>
                <div class="card-body p-3">
                    <p class="mb-1"><strong class="text-muted">Pembeli:</strong> {{ $trx->user->nama }}</p>
                    <p class="mb-2"><strong class="text-muted">Total:</strong> <span class="fw-bold text-primary">Rp {{ number_format($trx->total_harga,0,',','.') }}</span></p>
                     <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i> {{ $trx->created_at->format('d M Y') }}</small>
                </div>
                <div class="card-footer bg-white p-3 border-0">
                    <div class="row g-2 align-items-center">
                        <div class="col-8">
                            <form action="{{ route('pesanan.updateStatus', $trx->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option>Ubah Status</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="dikirim">Dikirim</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-4 d-grid">
                             <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-light text-center py-4">Belum ada pesanan yang masuk.</div>
        @endforelse
    </div>
</div>
@endsection