@extends('layout.public')
@section('title', 'Selesaikan Pembayaran') {{-- Judul lebih spesifik --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10"> {{-- Lebarkan sedikit container utama --}}
            <div class="text-center mb-5">
                <i class="fas fa-money-check-alt fa-4x text-primary mb-3 animated bounceIn"></i> {{-- Ikon lebih relevan, animasi sederhana --}}
                <h1 class="fw-bold text-secondary mb-3">Selesaikan Pembayaran Anda</h1> {{-- Judul utama lebih menonjol --}}
                <p class="lead text-muted">Selangkah lagi untuk menyelesaikan pesanan Anda. Pilih metode pembayaran yang paling nyaman.</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5"> {{-- Padding responsif --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="text-muted mb-0 small fw-medium">Nomor Transaksi</p>
                            <h5 class="fw-bold text-dark mb-0">#INV{{ $transaksi->id }}</h5>
                        </div>
                        <div class="text-end">
                            <p class="text-muted mb-0 small fw-medium">Batas Waktu Pembayaran</p>
                            <h6 class="fw-bold text-danger mb-0" id="countdown-timer">
                                @if($transaksi->created_at)
                                    {{ \Carbon\Carbon::parse($transaksi->created_at)->addHours(24)->format('d F Y, H:i') }}
                                @else
                                    Tidak Terbatas
                                @endif
                            </h6>
                        </div>
                    </div>
                    
                    <hr class="my-4">

                    <h5 class="fw-bold text-secondary mb-4">Ringkasan Pembayaran</h5>
                    <ul class="list-unstyled mb-4">
                        @foreach($transaksi->details as $detail)
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    @if($detail->produk && $detail->produk->foto)
                                        <img src="{{ asset('foto_produk/'.$detail->produk->foto) }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $detail->produk->nama }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded me-3" style="width:50px; height:50px;"><i class="fas fa-image text-muted fs-6"></i></div>
                                    @endif
                                    <div>
                                        <p class="fw-medium mb-0">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</p>
                                        <small class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                                <span class="fw-medium text-dark">Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                        @if($transaksi->ongkir && $transaksi->ongkir > 0)
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="fw-medium text-muted">Ongkos Kirim</span>
                                <span class="fw-medium text-dark">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                            </li>
                        @endif
                    </ul>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <p class="fs-4 fw-bold text-dark mb-0">Total Tagihan</p>
                        <p class="fs-2 fw-bold text-primary mb-0">Rp {{ number_format($transaksi->total_harga + ($transaksi->ongkir ?? 0), 0, ',', '.') }}</p> {{-- Sesuaikan jika ada ongkir --}}
                    </div>
                    
                    <hr class="my-4">

                    @if(!$transaksi->snap_token)
                        <div class="alert alert-danger text-center py-3 rounded-3">
                            <i class="fas fa-exclamation-circle me-2"></i> Gagal memuat gateway pembayaran. Silakan coba kembali nanti atau hubungi administrator.
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg rounded-pill fw-bold py-2">Kembali</a>
                        </div>
                    @else
                        <p class="fw-bold mb-3">Pilih Metode Pembayaran</p>
                        <div class="d-grid">
                            <button id="pay-button" class="btn btn-primary btn-lg rounded-pill fw-bold py-3">
                                <i class="fa fa-credit-card me-2"></i> Lanjutkan ke Pembayaran
                            </button>
                        </div>
                        <p class="text-center text-muted small mt-3">
                            <i class="fas fa-lock me-1"></i> Pembayaran Anda akan diproses melalui gateway Midtrans yang aman dan terenkripsi.
                        </p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-body p-4 text-center text-muted small">
                    <p class="mb-0">Perlu Bantuan? Silakan hubungi dukungan pelanggan kami.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="payment-form" action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="json" id="json_callback">
</form>
@endsection

@push('scripts')
{{-- Pastikan ini menggunakan key yang benar untuk environment Anda (sandbox/production) --}}
{{-- Contoh: Jika di local/testing, pakai sandbox. Jika live, pakai app.midtrans.com --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const countdownTimer = document.getElementById('countdown-timer');

        // Fungsi untuk mengupdate countdown timer
        function updateCountdown() {
            const transactionCreatedAt = '{{ $transaksi->created_at }}';
            const expiryTime = new Date(new Date(transactionCreatedAt).getTime() + (24 * 60 * 60 * 1000)); // 24 jam dari created_at
            const now = new Date();

            const timeLeft = expiryTime - now;

            if (timeLeft < 0) {
                if(countdownTimer) countdownTimer.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> Kadaluarsa</span>';
                if(payButton) payButton.disabled = true;
                return;
            }

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            let timerString = '';
            if (days > 0) timerString += `${days}h `;
            timerString += `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if(countdownTimer) countdownTimer.textContent = timerString;
        }

        // Jalankan countdown setiap detik
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Panggil sekali saat DOM loaded untuk inisialisasi

        if(payButton){
            payButton.addEventListener('click', function () {
                payButton.disabled = true;
                payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses Pembayaran...';
                
                // Pastikan snap_token ada sebelum memanggil snap.pay
                const snapToken = '{{ $transaksi->snap_token }}';
                if (!snapToken) {
                    alert("Token pembayaran tidak ditemukan. Silakan hubungi dukungan.");
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fa fa-credit-card me-2"></i> Lanjutkan ke Pembayaran';
                    return;
                }

                window.snap.pay(snapToken, {
                    onSuccess: function(result){
                        handlePaymentResult(result);
                    },
                    onPending: function(result){
                        handlePaymentResult(result);
                    },
                    onError: function(result){
                        alert("Pembayaran gagal. Silakan coba lagi.");
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fa fa-credit-card me-2"></i> Lanjutkan ke Pembayaran';
                    },
                    onClose: function(){
                        alert('Anda menutup pop-up pembayaran.');
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fa fa-credit-card me-2"></i> Lanjutkan ke Pembayaran';
                    }
                });
            });
        }

        function handlePaymentResult(result) {
            document.getElementById('json_callback').value = JSON.stringify(result);
            document.getElementById('payment-form').submit();
        }
    });
</script>
@endpush