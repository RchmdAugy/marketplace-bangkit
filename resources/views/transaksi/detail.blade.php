@extends('layout.public')
@section('title', 'Detail Transaksi')

@section('content')
<h2 class="mb-4 fw-bold text-center">Detail Transaksi</h2>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">Transaksi #{{ $transaksi->id }} | {{ $transaksi->created_at->format('d/m/Y H:i') }}</h5>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $transaksi->status == 'selesai' ? 'success' : ($transaksi->status == 'dikirim' ? 'info' : ($transaksi->status == 'diproses' ? 'warning text-dark' : 'bg-secondary')) }}">
                        {{ ucfirst($transaksi->status) }}
                    </span>
                </p>
                <table class="table table-hover align-middle shadow-sm rounded-4 overflow-hidden mb-3">
                    <thead class="table-primary">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $detail)
                        <tr>
                            <td>
                                <strong class="text-dark">{{ $detail->produk->nama ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $detail->produk->deskripsi ?? '' }}</small>
                            </td>
                            <td>Rp {{ number_format($detail->harga,0,',','.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->harga * $detail->jumlah,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="fw-bold fs-5">Total Harga: <span class="text-success">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span></p>
                <p class="mb-1"><strong>Pembeli:</strong> {{ $transaksi->user->nama }}</p>
                <p class="mb-3"><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}</p>
                <p><strong>Tanggal Pesan:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                @if($transaksi->snap_token)
                <p><strong>DEBUG:</strong> Snap Token = {{ $transaksi->snap_token }} | Transaksi ID = {{ $transaksi->id }}</p>
                @endif

                <div class="d-flex flex-wrap gap-2 mt-3">
                    @if(Auth::check() && Auth::user()->role == 'penjual' || Auth::user()->role == 'admin')
                        <a class="btn btn-outline-primary btn-sm rounded-pill px-3" href="{{ route('pesanan.index') }}"><i class="fa fa-arrow-left"></i> Kembali ke Pesanan</a>
                    @else
                        <a class="btn btn-outline-primary btn-sm rounded-pill px-3" href="{{ route('transaksi.index') }}"><i class="fa fa-arrow-left"></i> Kembali ke Riwayat</a>
                    @endif
                    @if(in_array($transaksi->status, ['dikirim', 'selesai']))
                        <a class="btn btn-success btn-sm rounded-pill px-3" href="{{ route('transaksi.invoice', $transaksi->id) }}"><i class="fa fa-file-pdf"></i> Cetak Invoice</a>
                    @endif
                    @if(Auth::check() && Auth::user()->role == 'pembeli')
                        <a class="btn btn-primary btn-sm rounded-pill px-3" href="{{ route('keranjang.index') }}"><i class="fa fa-shopping-cart"></i> Beli Lagi</a>
                    @endif
                    @if($transaksi->status == 'selesai' && Auth::id() == $transaksi->user_id)
                        <a class="btn btn-warning btn-sm rounded-pill px-3" href="{{ route('review.create', $transaksi->id) }}"><i class="fa fa-star"></i> Beri Ulasan</a>
                    @endif

                    @if($transaksi->status == 'menunggu pembayaran' && Auth::id() == $transaksi->user_id && $transaksi->snap_token)
                        <button id="pay-button-detail" class="btn btn-primary btn-sm rounded-pill px-3"><i class="fa fa-credit-card"></i> Bayar Sekarang</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButtonDetail = document.getElementById('pay-button-detail');
    if (payButtonDetail) {
        payButtonDetail.addEventListener('click', function () {
            window.snap.pay('{{ $transaksi->snap_token }}', {
                onSuccess: function(result){
                    // Kirim data pembayaran ke backend untuk konfirmasi
                    fetch('{{ route('transaksi.konfirmasi', $transaksi->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ json: JSON.stringify(result) })
                    }).then(response => {
                        if (response.ok) {
                            window.location.href = "{{ route('transaksi.index') }}";
                        } else {
                            alert("Konfirmasi pembayaran gagal di backend.");
                            console.error("Error during backend confirmation:", response);
                        }
                    }).catch(error => {
                        alert("Terjadi kesalahan jaringan saat konfirmasi pembayaran.");
                        console.error("Network error during backend confirmation:", error);
                    });
                },
                onPending: function(result){
                    fetch('{{ route('transaksi.konfirmasi', $transaksi->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ json: JSON.stringify(result) })
                    }).then(response => {
                        if (response.ok) {
                            window.location.href = "{{ route('transaksi.index') }}";
                        } else {
                            alert("Konfirmasi pembayaran gagal di backend (pending).");
                            console.error("Error during backend confirmation (pending):", response);
                        }
                    }).catch(error => {
                        alert("Terjadi kesalahan jaringan saat konfirmasi pembayaran (pending).");
                        console.error("Network error during backend confirmation (pending):", error);
                    });
                },
                onError: function(result){
                    alert("Pembayaran gagal. Silakan coba lagi.");
                }
            });
        });
    }
</script>
@endpush