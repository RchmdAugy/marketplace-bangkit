@extends('layout.public')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Selesaikan Pesanan Anda</h2>
        <p class="text-muted">Satu langkah lagi untuk mendapatkan produk impian Anda.</p>
    </div>

    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Alamat Pengiriman</h4>
                    <form action="{{ route('checkout.proses', $produk->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" required placeholder="Contoh: Jl. Pahlawan No. 10, RT 01/RW 02, Kelurahan, Kecamatan, Kota, Kode Pos">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-2 fw-bold">Lanjut ke Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Ringkasan Pesanan</h4>
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('foto_produk/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="ms-3">
                            <h6 class="mb-1 fw-medium">{{ $produk->nama }}</h6>
                            <p class="text-muted mb-0">1 x Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-medium">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection