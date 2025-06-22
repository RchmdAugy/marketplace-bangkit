@extends('layout.public')
@section('title', 'Toko ' . ($penjual->nama_toko ?? $penjual->nama))

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4 mb-5">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <img src="{{ $penjual->foto_profil ? asset('foto_profil/'.$penjual->foto_profil) : 'https://ui-avatars.com/api/?name='.$penjual->nama.'&background=10B981&color=fff&size=128' }}" class="img-fluid rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;" alt="Logo Toko">
                <div>
                    <h2 class="fw-bold mb-1">{{ $penjual->nama_toko ?? $penjual->nama }}</h2>
                    @if($penjual->nama_toko)
                        <p class="text-muted fs-5 mb-2">Oleh: {{ $penjual->nama }}</p>
                    @endif
                    @if($penjual->alamat_toko)
                        <p class="text-muted mb-0"><i class="fa fa-map-marker-alt me-2"></i>{{ $penjual->alamat_toko }}</p>
                    @endif
                    @if($penjual->no_telepon)
                        <p class="text-muted mb-0"><i class="fa fa-phone me-2"></i>{{ $penjual->no_telepon }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h3 class="fw-bold mb-4">Semua Produk dari {{ $penjual->nama_toko ?? $penjual->nama }}</h3>
    <div class="row g-4">
        @forelse($produks as $produk)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 rounded-4 shadow-sm">
                @if($produk->foto)
                    <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="card-img-top rounded-top-4" alt="{{ $produk->nama }}" style="height:220px; object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height:220px;"><i class="fa fa-image fa-3x text-secondary"></i></div>
                @endif
                <div class="card-body d-flex flex-column p-3">
                    <h5 class="card-title fw-semibold text-dark mb-1" style="font-size:1.1rem;"><a href="{{ route('produk.show', $produk->id) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($produk->nama, 45) }}</a></h5>
                    {{-- Nama penjual tidak perlu ditampilkan lagi karena ini sudah halaman penjual --}}
                    <p class="fw-bold fs-5 text-primary mt-auto">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light text-center py-5">
                <h4>Penjual ini belum memiliki produk yang ditampilkan.</h4>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection