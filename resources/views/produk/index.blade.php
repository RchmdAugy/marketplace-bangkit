@extends('layout.public')
@section('title', 'Daftar Produk')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-center mb-5" style="color: #1abc9c;">Daftar Produk</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(Auth::check() && Auth::user()->role == 'penjual')
        <div class="text-end mb-4">
            <a href="{{ route('produk.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Produk
            </a>
        </div>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color:#1abc9c; color:#fff;">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($produks as $produk)
                        <tr>
                            <td>{{ $produk->nama }}</td>
                            <td>Rp {{ number_format($produk->harga,0,',','.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td class="text-end">
                                <a class="btn btn-outline-primary btn-sm rounded-pill" href="{{ route('produk.show', $produk->id) }}"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-outline-warning btn-sm rounded-pill" href="{{ route('produk.edit', $produk->id) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-outline-danger btn-sm rounded-pill" href="{{ route('produk.delete', $produk->id) }}" onclick="return confirm('Yakin hapus?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
    <div class="row g-4">
        @foreach($produks as $produk)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 rounded-4 shadow-sm produk-card">
                @if($produk->foto)
                    <img src="{{ asset('foto_produk/'.$produk->foto) }}" class="card-img-top rounded-top-4" alt="Foto Produk" style="height:220px; object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height:220px;">
                        <i class="fa fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold text-dark mb-1" style="font-size:1.1rem;">{{ $produk->nama }}</h5>
                    <p class="text-muted mb-2 small">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 60) }}</p>
                    <p class="fw-bold fs-5 text-success mb-3" style="color:#1abc9c;">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                    <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-outline-primary w-100 rounded-pill mt-auto py-2 fw-medium">
                        <i class="fa fa-eye me-1"></i> Detail Produk
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
    .produk-card {
        transition: all 0.3s ease;
    }
    .produk-card:hover {
        box-shadow: 0 12px 40px rgba(26, 188, 156, 0.2);
        transform: translateY(-6px);
    }

    .btn-outline-primary {
        border: 2px solid #1abc9c;
        color: #1abc9c !important;
        transition: 0.3s;
    }
    .btn-outline-primary:hover {
        background-color: #1abc9c !important;
        color: white !important;
    }

    .btn-success {
        background-color: #1abc9c;
        border: none;
    }
    .btn-success:hover {
        background-color: #16a085;
    }

    .table > :not(:last-child) > :last-child > * {
        border-bottom: 2px solid #e9ecef;
    }
</style>
@endsection
