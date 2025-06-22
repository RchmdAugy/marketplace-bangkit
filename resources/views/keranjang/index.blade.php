@extends('layout.public')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <i class="fa fa-shopping-cart fa-2x text-primary me-3"></i>
        <h2 class="fw-bold mb-0">Keranjang Belanja Anda</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($items->count())
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach($items as $item)
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-3">
                                <img src="{{ asset('foto_produk/' . $item->produk->foto) }}" alt="{{ $item->produk->nama }}" class="img-fluid rounded-3">
                            </div>
                            <div class="col-md-4 col-9 mb-2 mb-md-0">
                                <h6 class="fw-semibold text-dark mb-1">{{ $item->produk->nama }}</h6>
                                <small class="text-muted">Oleh: {{ $item->produk->user->nama }}</small>
                            </div>
                            <div class="col-md-3 col-6">
                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex align-items-center quantity-form">
                                    @csrf
                                    <button type="button" class="btn btn-outline-secondary btn-sm quantity-minus" style="border-radius: 50% 0 0 50%;">-</button>
                                    <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" class="form-control form-control-sm rounded-0 text-center quantity-input" style="width: 60px;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm quantity-plus" style="border-radius: 0 50% 50% 0;">+</button>
                                </form>
                            </div>
                            <div class="col-md-2 col-4 text-md-end">
                                <span class="fw-bold">Rp {{ number_format($item->produk->harga * $item->jumlah,0,',','.') }}</span>
                            </div>
                            <div class="col-md-1 col-2 text-end">
                                <a href="{{ route('keranjang.remove', $item->id) }}" class="btn btn-sm btn-light text-danger" onclick="return confirm('Yakin hapus item ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <form action="{{ route('keranjang.checkout') }}" method="POST">
                            @csrf
                            <h4 class="fw-bold mb-3">Ringkasan Belanja</h4>
                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-medium">Alamat Lengkap Pengiriman</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap Anda...">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                            </div>
                            <hr>
                            @php
                                $grandTotal = $items->sum(function($item) {
                                    return $item->produk->harga * $item->jumlah;
                                });
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal ({{ $items->count() }} item)</span>
                                <span class="fw-medium">Rp {{ number_format($grandTotal,0,',','.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                                <span>Total Bayar</span>
                                <span class="text-primary">Rp {{ number_format($grandTotal,0,',','.') }}</span>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                    <i class="fa fa-shield-alt me-2"></i> Lanjut ke Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fa fa-shopping-cart fa-4x text-light mb-4"></i>
            <h4 class="fw-bold">Keranjang Anda masih kosong</h4>
            <p class="text-muted">Yuk, isi dengan produk-produk UMKM favoritmu!</p>
            <a href="{{ route('produk.index') }}" class="btn btn-primary rounded-pill px-5 mt-3">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityForms = document.querySelectorAll('.quantity-form');

    quantityForms.forEach(form => {
        const minusBtn = form.querySelector('.quantity-minus');
        const plusBtn = form.querySelector('.quantity-plus');
        const input = form.querySelector('.quantity-input');
        let debounceTimer;

        const submitForm = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                form.submit();
            }, 500); // Tunggu 500ms setelah user berhenti klik sebelum submit
        };

        minusBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                submitForm();
            }
        });

        plusBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value);
            let maxStok = parseInt(input.getAttribute('max'));
            if (currentValue < maxStok) {
                input.value = currentValue + 1;
                submitForm();
            }
        });
    });
});
</script>
@endpush