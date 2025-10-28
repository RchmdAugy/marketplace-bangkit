@extends('layout.public')
@section('title', 'Toko ' . ($penjual->nama_toko ?? $penjual->nama))

@section('content')
<div class="container py-5">
    
    {{-- Bagian Header Toko (Tidak Berubah) --}}
    <div class="card shadow-lg border-0 rounded-4 mb-5">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <img src="{{ $penjual->foto_profil ? asset('foto_profil/'.$penjual->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($penjual->nama).'&background=10B981&color=fff&size=128' }}" 
                     class="img-fluid rounded-circle shadow-sm" 
                     style="width: 120px; height: 120px; object-fit: cover; flex-shrink: 0;" 
                     alt="Logo Toko">
                
                <div class="flex-grow-1 text-center text-md-start">
                    <h2 class="fw-bold text-secondary mb-1">{{ $penjual->nama_toko ?? $penjual->nama }}</h2>
                    @if($penjual->nama_toko)
                        <p class="text-muted fs-5 mb-2">Oleh: {{ $penjual->nama }}</p>
                    @endif
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mt-3">
                        @if($penjual->alamat_toko)
                            <span class="text-muted"><i class="fa fa-map-marker-alt me-2 text-primary opacity-75"></i>{{ $penjual->alamat_toko }}</span>
                        @endif
                        @if($penjual->no_telepon)
                            <span class="text-muted"><i class="fa fa-phone me-2 text-primary opacity-75"></i>{{ $penjual->no_telepon }}</span>
                        @endif
                    </div>
                </div>

                <div class="ms-md-auto text-center text-md-end border-md-start ps-md-4 mt-4 mt-md-0">
                    <span class="text-muted fw-medium">Total Produk</span>
                    <h2 class="fw-bold text-primary mb-0 display-6">{{ $produks->count() }}</h2>
                </div>

            </div>
        </div>
    </div>

    <h3 class="fw-bold mb-4 text-secondary">Semua Produk dari Toko Ini</h3>
    <div class="row g-3 g-md-4">
        @forelse($produks as $produk)
        
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 rounded-4 shadow-sm product-card-hover">
                
                @if($produk->foto)
                    <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="card-img-top rounded-top-4 product-grid-image" alt="{{ $produk->nama }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4 product-grid-image-placeholder">
                        <i class="fa fa-image fa-3x text-secondary opacity-50"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column p-3">
                    <h5 class="card-title fw-semibold text-dark mb-1 product-title-grid">
                        <a href="{{ route('produk.show', $produk->id) }}" class="text-decoration-none text-dark stretched-link">{{ $produk->nama }}</a>
                    </h5>

                    {{-- =================================== --}}
                    {{-- ==  TAMBAHKAN KATEGORI DI SINI   == --}}
                    {{-- =================================== --}}
                    @if($produk->category)
                        <span class="badge bg-light text-secondary rounded-pill px-2 py-1 mb-2 align-self-start" style="font-size: 0.75rem;">
                            {{ $produk->category->name }}
                        </span>
                    @endif
                    {{-- =================================== --}}
                    
                    <div class="mb-2">
                        @php
                            $averageRating = $produk->reviews->avg('rating');
                            $roundedRating = round($averageRating);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star fa-sm {{ $i <= $roundedRating ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                        @endfor
                        <span class="text-muted ms-1" style="font-size: 0.85rem;">({{ $produk->reviews->count() }})</span>
                    </div>

                    <p class="fw-bold fs-5 text-primary mt-auto mb-0">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                </div>
            </div>
        </div>
        
        @empty
        
        <div class="col-12">
            <div class="card border-0 bg-light rounded-4">
                <div class="card-body text-center text-muted py-5">
                    <i class="fa fa-store fa-4x mb-4"></i>
                    <h4 class="fw-semibold">Toko Ini Belum Punya Produk</h4>
                    <p class="mb-0">Sepertinya penjual belum menambahkan produk apa pun ke etalasenya.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
