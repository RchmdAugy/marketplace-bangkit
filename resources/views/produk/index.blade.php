@extends('layout.public')
@section('title', 'Daftar Produk')

@section('content')
<div class="container py-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Logika ini akan memeriksa apakah pengguna adalah penjual atau bukan --}}
    @if(Auth::check() && Auth::user()->role == 'penjual')
        
        {{-- =============================================== --}}
        {{-- ============ TAMPILAN UNTUK PENJUAL =========== --}}
        {{-- =============================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Manajemen Produk Anda</h2>
            <a href="{{ route('produk.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fa fa-plus me-2"></i> Tambah Produk
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 d-none d-lg-block">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Nama Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($produks as $produk)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($produk->foto)
                                            <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <span class="fw-medium">{{ $produk->nama }}</span>
                                    </div>
                                </td>
                                <td class="text-center">Rp {{ number_format($produk->harga,0,',','.') }}</td>
                                <td class="text-center">{{ $produk->stok }}</td>
                                <td class="text-center">
                                    @if($produk->is_approved)
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-light" href="{{ route('produk.show', $produk->id) }}" title="Lihat"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-sm btn-light" href="{{ route('produk.edit', $produk->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('produk.delete', $produk->id) }}" method="GET" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4">Anda belum memiliki produk.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-block d-lg-none">
            @forelse($produks as $produk)
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-3">
                                @if($produk->foto)
                                    <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="img-fluid rounded-3" style="height: 80px; width: 100%; object-fit: cover;">
                                @else
                                     <div class="bg-light d-flex align-items-center justify-content-center rounded-3 w-100 h-100"><i class="fa fa-image fa-2x text-secondary"></i></div>
                                @endif
                            </div>
                            <div class="col-9">
                                <span class="fw-semibold text-dark d-block">{{ $produk->nama }}</span>
                                <small class="text-muted">Rp {{ number_format($produk->harga,0,',','.') }} ・ Stok: {{ $produk->stok }}</small>
                                <div>
                                    @if($produk->is_approved)
                                        <span class="badge bg-success-subtle text-success-emphasis">Disetujui</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <div class="d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-secondary rounded-pill px-3" href="{{ route('produk.show', $produk->id) }}">Lihat</a>
                                    <a class="btn btn-sm btn-outline-primary rounded-pill px-3" href="{{ route('produk.edit', $produk->id) }}">Edit</a>
                                     <form action="{{ route('produk.delete', $produk->id) }}" method="GET" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="alert alert-light text-center py-4">Anda belum memiliki produk.</div>
            @endforelse
        </div>

    @else
        {{-- =============================================== --}}
        {{-- ========= TAMPILAN UNTUK PEMBELI & TAMU ======== --}}
        {{-- =============================================== --}}
        <h2 class="fw-bold text-center mb-5">Jelajahi Produk Pilihan</h2>
        <div class="row g-4">
            @forelse($produks as $produk)
                <div class="col-md-4 col-lg-3 col-6">
                    <div class="card h-100 border-0 rounded-4 shadow-sm">
                        @if($produk->foto)
                            <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="card-img-top rounded-top-4" alt="{{ $produk->nama }}" style="height:180px; object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height:180px;"><i class="fa fa-image fa-3x text-secondary"></i></div>
                        @endif
                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-semibold text-dark mb-1" style="font-size:1rem;"><a href="{{ route('produk.show', $produk->id) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($produk->nama, 35) }}</a></h5>
                            <p class="small text-muted mb-2"><i class="fa fa-store me-1"></i> {{ $produk->user->nama_toko ?? $produk->user->nama }}</p>
                            <p class="fw-bold fs-5 text-primary mt-auto">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-5">
                        <h4>Oops! Belum ada produk yang tersedia.</h4>
                        <p class="text-muted">Silakan cek kembali nanti.</p>
                    </div>
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection