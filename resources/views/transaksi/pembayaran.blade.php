@extends('layout.public')
@section('title', 'Pembayaran Transaksi')

@section('content')
<h2 class="border-bottom pb-2 mb-3 fw-bold text-primary text-center">Pembayaran</h2>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <h5 class="card-title fw-bold text-primary mb-3">Total Bayar</h5>
        <p class="fs-4 fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        <p class="mb-1"><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}</p>
        @if($transaksi->snap_token)
        <p class="mb-3"><strong>DEBUG:</strong> Snap Token = {{ $transaksi->snap_token }} | Transaksi ID = {{ $transaksi->id }}</p>
        @endif
        <hr class="my-3">
        @if(!$transaksi->snap_token)
            <div class="alert alert-danger text-center shadow-sm rounded-4 py-3">
                <i class="fa fa-exclamation-triangle me-2"></i>Gagal memuat pembayaran: Snap token kosong. Silakan ulangi checkout atau hubungi admin.
            </div>
        @endif
        <button id="pay-button" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold" @if(!$transaksi->snap_token) disabled @endif><i class="fa fa-credit-card me-2"></i> Bayar Sekarang</button>
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
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $transaksi->snap_token }}', {
            onSuccess: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
                setTimeout(function() {
                    window.location.href = "{{ route('transaksi.index') }}";
                }, 1000);
            },
            onPending: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
                setTimeout(function() {
                    window.location.href = "{{ route('transaksi.index') }}";
                }, 1000);
            },
            onError: function(result){
                alert("Pembayaran gagal. Silakan coba lagi.");
            }
        });
    });
</script>
@endpush
