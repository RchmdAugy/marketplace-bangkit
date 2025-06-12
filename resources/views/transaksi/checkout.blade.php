@extends('layout.public')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4 fw-bold text-primary">Checkout</h2>

                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Detail Produk</h5>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="rounded-3" style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="ms-3">
                                <h6 class="mb-1">{{ $produk->nama }}</h6>
                                <p class="text-muted mb-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

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
                            <label for="alamat" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Lanjut ke Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection