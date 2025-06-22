@extends('layout.public')
@section('title', 'Pembayaran Transaksi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="text-center mb-4">
                <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold">Konfirmasi Pembayaran</h2>
                <p class="text-muted">Pilih metode pembayaran yang paling nyaman untuk Anda.</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Total Tagihan</p>
                            <p class="fs-2 fw-bold text-primary mb-0">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-muted">#INV{{ $transaksi->id }}</span>
                    </div>
                    <hr class="my-4">
                    <p class="mb-1"><strong>Alamat Pengiriman:</strong></p>
                    <p class="text-muted">{{ $transaksi->alamat_pengiriman }}</p>
                    
                    @if(!$transaksi->snap_token)
                        <div class="alert alert-danger text-center py-3">Gagal memuat gateway pembayaran.</div>
                    @else
                        <div class="d-grid">
                            <button id="pay-button" class="btn btn-primary btn-lg rounded-pill fw-bold py-2"><i class="fa fa-credit-card me-2"></i> Bayar Sekarang</button>
                        </div>
                        <p class="text-center text-muted small mt-3">Anda akan diarahkan ke halaman pembayaran Midtrans yang aman.</p>
                    @endif
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
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    if(payButton){
        payButton.addEventListener('click', function () {
            payButton.disabled = true;
            payButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
            window.snap.pay('{{ $transaksi->snap_token }}', {
                onSuccess: function(result){
                    handlePaymentResult(result);
                },
                onPending: function(result){
                    handlePaymentResult(result);
                },
                onError: function(result){
                    alert("Pembayaran gagal. Silakan coba lagi.");
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fa fa-credit-card me-2"></i> Bayar Sekarang';
                },
                onClose: function(){
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fa fa-credit-card me-2"></i> Bayar Sekarang';
                }
            });
        });
    }

    function handlePaymentResult(result) {
        document.getElementById('json_callback').value = JSON.stringify(result);
        document.getElementById('payment-form').submit();
    }
</script>
@endpush