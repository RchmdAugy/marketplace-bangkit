@extends('layout.public')
@section('title', 'Selesaikan Pesanan') {{-- Ganti title lebih spesifik --}}

@section('content')
<div class="container py-5">
    <div class="text-center mb-5"> {{-- Margin bawah sedikit lebih besar --}}
        <h1 class="fw-bold text-secondary mb-3">Selesaikan Pesanan Anda</h1> {{-- Ganti h2 ke h1, warna teks lebih konsisten --}}
        <p class="lead text-muted">Satu langkah lagi untuk mendapatkan produk impian Anda.</p> {{-- Gunakan kelas lead --}}
    </div>

    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 p-md-5"> {{-- Padding responsif --}}
                    <h4 class="fw-bold mb-4 text-primary">Detail Pengiriman</h4> {{-- Judul lebih menonjol --}}
                    <form action="{{ route('checkout.proses', $produk->id) }}" method="POST" id="checkoutForm"> {{-- Tambah ID form --}}
                        @csrf

                        {{-- Section Produk yang Dipesan --}}
                        <div class="mb-4 pb-4 border-bottom">
                            <h5 class="fw-semibold mb-3">Produk yang Dipesan</h5>
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('foto_produk/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="rounded-3 me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-1 fw-bold text-secondary">{{ $produk->nama }}</h5>
                                    <p class="text-muted mb-0">Stok Tersedia: {{ $produk->stok }}</p>
                                    <p class="text-muted mb-0">Oleh: <span class="fw-medium">{{ $produk->penjual->nama_toko }}</span></p> {{-- Asumsi ada relasi penjual --}}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label fw-medium">Jumlah Produk</label>
                                <div class="input-group input-group-lg"> {{-- Menggunakan input-group-lg --}}
                                    <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                                    <input type="number" class="form-control text-center @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required>
                                    <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Section Alamat Pengiriman --}}
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-3">Alamat Lengkap Pengiriman</h5>
                            <textarea class="form-control form-control-lg @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" required placeholder="Contoh: Jl. Pahlawan No. 10, RT 01/RW 02, Kelurahan, Kecamatan, Kota, Kode Pos">{{ old('alamat', Auth::check() ? Auth::user()->alamat : '') }}</textarea> {{-- Auto-fill jika user login --}}
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold">Lanjut ke Pembayaran</button> {{-- Tombol lebih besar --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;"> {{-- top 100px agar tidak menempel navbar --}}
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4 text-secondary">Ringkasan Pesanan</h4>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Harga Produk (per item)</span>
                        <span class="fw-medium">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Jumlah</span>
                        <span class="fw-medium" id="displayJumlah">1</span>
                    </div>
                    
                    <hr class="mb-3">

                    <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mt-3">
                        <span>Total Pembayaran</span>
                        <span class="text-primary" id="totalHarga">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <small class="d-block text-muted mt-3 text-center">Dengan melanjutkan, Anda menyetujui <a href="#" class="text-primary text-decoration-none fw-medium">Syarat dan Ketentuan</a> kami.</small>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jumlahInput = document.getElementById('jumlah');
        const buttonMinus = document.getElementById('button-minus');
        const buttonPlus = document.getElementById('button-plus');
        const totalHargaSpan = document.getElementById('totalHarga');
        const displayJumlahSpan = document.getElementById('displayJumlah');
        const produkHarga = {{ $produk->harga }}; // Ambil harga produk dari PHP

        // Fungsi untuk memperbarui total harga
        function updateTotalHarga() {
            let jumlah = parseInt(jumlahInput.value);
            if (isNaN(jumlah) || jumlah < 1) {
                jumlah = 1;
                jumlahInput.value = 1;
            }
            if (jumlah > {{ $produk->stok }}) {
                jumlah = {{ $produk->stok }};
                jumlahInput.value = {{ $produk->stok }};
            }

            const total = jumlah * produkHarga;
            totalHargaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID'); // Format ke Rupiah
            displayJumlahSpan.textContent = jumlah; // Update display jumlah di ringkasan
        }

        // Event listener untuk tombol minus
        if (buttonMinus) {
            buttonMinus.addEventListener('click', function() {
                let currentValue = parseInt(jumlahInput.value);
                if (currentValue > 1) {
                    jumlahInput.value = currentValue - 1;
                    updateTotalHarga();
                }
            });
        }

        // Event listener untuk tombol plus
        if (buttonPlus) {
            buttonPlus.addEventListener('click', function() {
                let currentValue = parseInt(jumlahInput.value);
                if (currentValue < {{ $produk->stok }}) {
                    jumlahInput.value = currentValue + 1;
                    updateTotalHarga();
                }
            });
        }

        // Event listener untuk perubahan manual pada input jumlah
        if (jumlahInput) {
            jumlahInput.addEventListener('input', updateTotalHarga);
            jumlahInput.addEventListener('change', updateTotalHarga); // Untuk memastikan update saat input selesai diedit
        }

        // Inisialisasi total harga saat halaman dimuat
        updateTotalHarga();
    });
</script>
@endpush