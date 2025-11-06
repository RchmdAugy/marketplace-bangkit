@extends('layout.public')
@section('title', 'Pesanan Masuk')

{{-- Font Awesome --}}
@push('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center text-secondary">Pesanan Masuk</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
             <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
             <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Desktop --}}
    <div class="card shadow-sm border-0 rounded-4 d-none d-lg-block">
        <div class="card-body p-0"> {{-- Hapus padding agar table full width --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0"> {{-- Hapus mb-0 jika tidak perlu --}}
                    <thead class="table-light"> {{-- Header table lebih jelas --}}
                        <tr class="text-secondary fw-semibold" style="font-size: 0.85rem;">
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Pembeli</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4" style="width: 220px;">Ubah Status</th>
                            <th class="text-center py-3 px-4" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pesanans as $trx)
                        <tr>
                            <td class="fw-medium px-4">#{{ $trx->id }}</td>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $trx->user->foto_profil ? asset('foto_profil/'.$trx->user->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($trx->user->nama).'&background=E2E8F0&color=334155&size=64' }}"
                                         class="rounded-circle me-2 shadow-sm" style="width: 32px; height: 32px; object-fit: cover;" alt="Foto">
                                    <span class="fw-medium text-dark">{{ $trx->user->nama }}</span>
                                </div>
                            </td>
                            <td class="fw-bold px-4">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                            <td class="px-4">
                                {{-- =============================================== --}}
                                {{-- ==  PERUBAHAN WARNA BADGE ADA DI SINI       == --}}
                                {{-- =============================================== --}}
                                <span class="badge rounded-pill fs-6 px-3 py-2 text-capitalize
                                    @switch($trx->status)
                                        @case('selesai') bg-success-subtle text-success-emphasis @break
                                        @case('dikirim') bg-info-subtle text-info-emphasis @break
                                        @case('diproses') bg-warning-subtle text-warning-emphasis @break
                                        @case('menunggu pembayaran') bg-warning-subtle text-warning-emphasis @break {{-- Samakan dengan diproses atau ganti warna lain --}}
                                        @default bg-secondary-subtle text-secondary-emphasis
                                    @endswitch">
                                    {{ str_replace('_', ' ', $trx->status) }}
                                </span>
                            </td>
                            <td class="px-4">
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
                            <td class="text-center px-4">
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Lihat Detail">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa fa-inbox fa-3x mb-3 opacity-50"></i>
                                <h5 class="fw-medium">Belum ada pesanan yang masuk.</h5>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tampilan Mobile --}}
    <div class="d-block d-lg-none">
        @forelse($pesanans as $trx)
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-primary mb-0">Pesanan #{{ $trx->id }}</h6>
                    <small class="text-muted">{{ $trx->created_at->format('d M Y') }}</small>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Pembeli:</span>
                        <span class="fw-medium text-dark">{{ $trx->user->nama }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Total:</span>
                        <span class="fw-bold text-primary fs-5">Rp {{ number_format($trx->total_harga,0,',','.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Status:</span>
                        <span class="badge rounded-pill fs-6 px-3 py-2 text-capitalize
                            @switch($trx->status)
                                @case('selesai') bg-success-subtle text-success-emphasis @break
                                @case('dikirim') bg-info-subtle text-info-emphasis @break
                                @case('diproses') bg-warning-subtle text-warning-emphasis @break
                                @case('menunggu pembayaran') bg-warning-subtle text-warning-emphasis @break
                                @default bg-secondary-subtle text-secondary-emphasis
                            @endswitch">
                            {{ str_replace('_', ' ', $trx->status) }}
                        </span>
                    </div>
                     <form action="{{ route('pesanan.updateStatus', $trx->id) }}" method="POST" class="mb-2">
                        @csrf
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="menunggu pembayaran" @if($trx->status=='menunggu pembayaran') selected @endif>Menunggu Pembayaran</option>
                            <option value="diproses" @if($trx->status=='diproses') selected @endif>Diproses</option>
                            <option value="dikirim" @if($trx->status=='dikirim') selected @endif>Dikirim</option>
                            <option value="selesai" @if($trx->status=='selesai') selected @endif>Selesai</option>
                        </select>
                    </form>
                    <div class="d-grid">
                        <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Detail Pesanan</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card border-0 bg-light rounded-4 shadow-sm">
                <div class="card-body text-center text-muted py-5">
                    <i class="fa fa-inbox fa-4x mb-4 opacity-50"></i>
                    <h4 class="fw-semibold">Belum Ada Pesanan</h4>
                    <p class="mb-0">Belum ada pesanan yang masuk ke toko Anda.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection