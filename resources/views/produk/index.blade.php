@extends('layout.public')

{{-- Judul Halaman Dibuat Dinamis --}}
@section('title', isset($currentCategory) ? 'Produk Kategori: '.$currentCategory->name : 'Daftar Produk')

@section('content')
<div class="container py-5">

    @if(Auth::check() && Auth::user()->role == 'penjual')
        {{-- =============================================== --}}
        {{-- ============ TAMPILAN UNTUK PENJUAL =========== --}}
        {{-- =============================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0 text-secondary">Manajemen Produk Anda</h2>
            <a href="{{ route('produk.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fa fa-plus me-2"></i> Tambah Produk
            </a>
        </div>

        {{-- Tabel untuk Desktop --}}
        <div class="card border-0 shadow-sm rounded-4 d-none d-lg-block">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary fw-semibold">
                                <th style="width: 45%;">Nama Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-end" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($produks as $produk)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($produk->foto)
                                            <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="rounded-3 me-3 product-thumb-sm">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded-3 me-3 product-thumb-sm">
                                                <i class="fa fa-image text-secondary fa-lg"></i>
                                            </div>
                                        @endif
                                        <span class="fw-medium text-dark">{{ $produk->nama }}</span>
                                    </div>
                                </td>
                                <td class="text-center text-secondary">Rp {{ number_format($produk->harga,0,',','.') }}</td>
                                <td class="text-center text-secondary">{{ $produk->stok }}</td>
                                <td class="text-center">
                                    @if($produk->is_approved)
                                        <span class="badge bg-success-subtle text-success-emphasis py-2 px-3 fw-semibold">
                                            <i class="fa fa-check-circle me-1"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis py-2 px-3 fw-semibold">
                                            <i class="fa fa-clock me-1"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('produk.show', $produk->id) }}" title="Lihat"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-outline-primary btn-sm rounded-pill" href="{{ route('produk.edit', $produk->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill" title="Hapus"><i class="fa fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fa fa-box-open fa-2x mb-2"></i>
                                    <p class="mb-0">Anda belum memiliki produk.</p>
                                    <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm mt-3 rounded-pill">Tambah Produk Pertama Anda</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Card List untuk Mobile --}}
        <div class="d-block d-lg-none">
            @forelse($produks as $produk)
                <div class="card shadow-sm border-0 rounded-4 mb-3 product-card-mobile">
                    <div class="card-body p-3">
                        <div class="row g-2 align-items-center">
                            <div class="col-4">
                                @if($produk->foto)
                                    <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="img-fluid rounded-3 w-100 product-thumb-mobile">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-3 w-100 product-thumb-mobile-placeholder"><i class="fa fa-image fa-2x text-secondary"></i></div>
                                @endif
                            </div>
                            <div class="col-8">
                                <span class="fw-semibold text-dark d-block">{{ $produk->nama }}</span>
                                <small class="text-muted d-block mb-1">Rp {{ number_format($produk->harga,0,',','.') }} ・ Stok: {{ $produk->stok }}</small>
                                <div>
                                    @if($produk->is_approved)
                                        <span class="badge bg-success-subtle text-success-emphasis fw-semibold">Disetujui</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis fw-semibold">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <hr class="my-2 border-top border-secondary opacity-25">
                                <div class="d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-secondary rounded-pill px-3" href="{{ route('produk.show', $produk->id) }}">Lihat</a>
                                    <a class="btn btn-sm btn-outline-primary rounded-pill px-3" href="{{ route('produk.edit', $produk->id) }}">Edit</a>
                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-light text-center py-4 border-0 shadow-sm rounded-4">
                    <i class="fa fa-box-open fa-3x mb-3 text-secondary"></i>
                    <h4 class="fw-bold text-secondary">Anda belum memiliki produk.</h4>
                    <p class="text-muted mb-4">Mulai jual produk Anda di Marketplace BANGKIT sekarang!</p>
                    <a href="{{ route('produk.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="fa fa-plus me-2"></i> Tambah Produk Baru
                    </a>
                </div>
            @endforelse
        </div>

    @else
        {{-- =============================================== --}}
        {{-- ========= TAMPILAN UNTUK PEMBELI & TAMU ======== --}}
        {{-- =============================================== --}}
        
        <h2 class="fw-bold text-center mb-3 text-secondary">
             @if(isset($currentCategory))
                Produk Kategori: {{ $currentCategory->name }}
             @else
                Jelajahi Semua Produk
             @endif
        </h2>

        <div class="text-center mb-5">
            <a href="{{ route('produk.index') }}" 
               class="btn btn-sm rounded-pill me-2 mb-2 {{ !isset($currentCategory) ? 'btn-primary' : 'btn-outline-secondary' }}">
               Semua Kategori
            </a>
            @foreach($categories as $cat)
                 <a href="{{ route('produk.by_category', $cat->slug) }}" 
                    class="btn btn-sm rounded-pill me-2 mb-2 {{ isset($currentCategory) && $currentCategory->id == $cat->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                    {{ $cat->name }}
                 </a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse($produks as $produk)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6"> 
                    <div class="card h-100 border-0 rounded-4 shadow-sm product-card-hover"> 
                        <a href="{{ route('produk.show', $produk->id) }}" class="text-decoration-none">
                            @if($produk->foto)
                                <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="card-img-top rounded-top-4 product-grid-image" alt="{{ $produk->nama }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4 product-grid-image-placeholder"><i class="fa fa-image fa-3x text-secondary"></i></div>
                            @endif
                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title fw-semibold text-dark mb-1 product-title-grid">{{ Str::limit($produk->nama, 35) }}</h5>
                                
                                @if($produk->category)
                                    <span class="badge bg-light text-secondary rounded-pill px-2 py-1 mb-2 align-self-start" style="font-size: 0.75rem;">{{ $produk->category->name }}</span>
                                @endif

                                <p class="small text-muted mb-2"><i class="fa fa-store me-1"></i> {{ $produk->user->nama_toko ?? $produk->user->nama }}</p>
                                <p class="fw-bold fs-5 text-primary mt-auto">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                                @if($produk->stok <= 0)
                                    <span class="badge bg-danger-subtle text-danger-emphasis fw-semibold mt-2">Stok Habis</span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-5 border-0 shadow-sm rounded-4">
                        <i class="fa fa-box-open fa-3x mb-3 text-secondary"></i>
                        <h4 class="fw-bold text-secondary">Oops! Belum ada produk.</h4>
                        @if(isset($currentCategory))
                             <p class="text-muted mb-0">Belum ada produk yang tersedia dalam kategori <strong>{{ $currentCategory->name }}</strong>.</p>
                        @else
                             <p class="text-muted mb-0">Belum ada produk yang tersedia di marketplace ini.</p>
                        @endif
                         <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-primary rounded-pill mt-3">Lihat Semua Kategori</a>
                    </div>
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); 
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data produk yang sudah dihapus tidak dapat dikembalikan!",
                icon: "warning",
                buttons: {
                    cancel: { text: "Batal", value: null, visible: true, className: "swal-button swal-button--cancel" },
                    confirm: { text: "Ya, Hapus!", value: true, visible: true, className: "swal-button swal-button--danger" }
                },
                dangerMode: true
            })
            .then((willDelete) => {
                if (willDelete) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
