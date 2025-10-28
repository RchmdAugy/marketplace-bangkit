@extends('layout.public')
@section('title', 'Detail Transaksi #'.$transaksi->id)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10"> {{-- Lebarkan sedikit container utama --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 py-2"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
                @if(in_array($transaksi->status, ['dikirim', 'selesai']))
                    <a class="btn btn-primary rounded-pill px-4 py-2" href="{{ route('transaksi.invoice', $transaksi->id) }}" target="_blank"><i class="fa fa-file-pdf me-2"></i> Cetak Invoice</a> {{-- Tambah target="_blank" --}}
                @endif
            </div>

            <div class="card shadow-lg border-0 rounded-4 mb-4"> {{-- Shadow lebih kuat --}}
                <div class="card-header bg-white border-bottom-0 p-4 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2"> {{-- Tambah flex-wrap untuk responsif --}}
                        <div>
                            <h3 class="fw-bold text-secondary mb-1">Detail Transaksi</h3> {{-- Ubah h4 ke h3 --}}
                            <p class="text-primary fw-medium mb-0">#INV{{ $transaksi->id }}</p> {{-- ID invoice lebih menonjol --}}
                        </div>
                        <span class="badge fs-6 px-3 py-2 rounded-pill text-capitalize 
                            @switch($transaksi->status)
                                @case('selesai') bg-success text-white @break
                                @case('dikirim') bg-info text-white @break
                                @case('diproses') bg-warning text-dark @break
                                @case('menunggu pembayaran') bg-danger text-white @break {{-- Perbaiki status menunggu pembayaran --}}
                                @default bg-secondary text-white
                            @endswitch">
                            <i class="fas fa-circle-dot me-2" style="font-size: 0.7em;"></i> {{ str_replace('_', ' ', $transaksi->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5"> {{-- Padding responsif --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block mb-1">Tanggal Transaksi</strong>
                            <p class="mb-0 text-dark">{{ $transaksi->created_at->format('d F Y, H:i') }}</p> {{-- Format tanggal lebih lengkap --}}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block mb-1">Pembeli</strong>
                            <p class="mb-0 text-dark">{{ $transaksi->user->nama }}</p>
                        </div>
                        @if($transaksi->penjual) {{-- Asumsi ada relasi penjual di Transaksi --}}
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block mb-1">Penjual</strong>
                            <p class="mb-0 text-dark">{{ $transaksi->penjual->nama_toko ?? $transaksi->penjual->nama }}</p>
                        </div>
                        @endif
                        <div class="col-12 mt-3">
                            <strong class="text-muted d-block mb-1">Alamat Pengiriman</strong>
                            <p class="mb-0 text-dark">{{ $transaksi->alamat_pengiriman }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-4 text-secondary">Produk yang Dipesan</h5>
                    <div class="list-group list-group-flush border-bottom mb-4"> {{-- Styling list group lebih rapi --}}
                    @foreach($transaksi->details as $detail)
                        <div class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                @if($detail->produk && $detail->produk->foto)
                                    <img src="{{ asset('foto_produk/' . $detail->produk->foto) }}" alt="{{ $detail->produk->nama }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light rounded me-3" style="width: 70px; height: 70px;"><i class="fas fa-image text-muted fs-4"></i></div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</h6>
                                    <small class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</small>
                                </div>
                            </div>
                            <span class="fw-bold text-dark">Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    </div>

                    <div class="d-flex justify-content-between align-items-center fs-5 fw-bold mb-3">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>

                    @if($transaksi->status == 'menunggu pembayaran' && Auth::id() == $transaksi->user_id && $transaksi->snap_token)
                        <div class="d-grid mt-4 pt-3 border-top">
                            <button id="payButton" class="btn btn-primary rounded-pill btn-lg py-3 fw-bold"><i class="fa fa-credit-card me-2"></i> Lanjutkan Pembayaran</button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tambahan untuk informasi status yang lebih visual (opsional) --}}
            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4 text-secondary">Informasi Status Transaksi</h5>
                    <p class="text-muted">Status transaksi Anda saat ini adalah: <span class="fw-semibold text-capitalize text-dark">{{ str_replace('_', ' ', $transaksi->status) }}</span>.</p>
                    <ul class="list-unstyled mb-0">
                        @if($transaksi->status == 'menunggu pembayaran')
                            <li><i class="fas fa-exclamation-circle text-warning me-2"></i> Mohon selesaikan pembayaran Anda sebelum: <strong>{{ $transaksi->created_at->addHours(24)->format('d M Y, H:i') }}</strong>.</li>
                        @elseif($transaksi->status == 'diproses')
                            <li><i class="fas fa-sync-alt text-info me-2"></i> Pesanan Anda sedang diproses oleh penjual.</li>
                        @elseif($transaksi->status == 'dikirim')
                            <li><i class="fas fa-truck text-primary me-2"></i> Pesanan Anda telah dikirim.</li>
                            {{-- Tambahkan nomor resi jika tersedia --}}
                            @if($transaksi->nomor_resi)
                                <li><i class="fas fa-barcode text-primary me-2"></i> Nomor Resi: <span class="fw-semibold">{{ $transaksi->nomor_resi }}</span></li>
                            @endif
                        @elseif($transaksi->status == 'selesai')
                            <li><i class="fas fa-check-circle text-success me-2"></i> Pesanan Anda telah selesai.</li>
                        @else
                            <li><i class="fas fa-info-circle text-muted me-2"></i> Informasi lebih lanjut akan diperbarui.</li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($transaksi->status == 'menunggu pembayaran' && Auth::id() == $transaksi->user_id && $transaksi->snap_token)
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('payButton');
        if (payButton) {
            payButton.addEventListener('click', function () {
                // Untuk demo, kita arahkan ke rute pembayaran atau langsung ke Midtrans Snap JS
                // Karena Anda sudah memiliki route 'transaksi.pembayaran', kita bisa pakai itu.
                // Jika ingin langsung menampilkan pop-up Midtrans, gunakan:
                // snap.pay('{{ $transaksi->snap_token }}', {
                //     onSuccess: function(result){
                //         alert('Pembayaran berhasil!');
                //         window.location.href = '{{ route('transaksi.show', $transaksi->id) }}'; // Redirect ke halaman detail transaksi
                //     },
                //     onPending: function(result){
                //         alert('Pembayaran tertunda!');
                //         window.location.href = '{{ route('transaksi.show', $transaksi->id) }}';
                //     },
                //     onError: function(result){
                //         alert('Pembayaran gagal!');
                //         window.location.href = '{{ route('transaksi.show', $transaksi->id) }}';
                //     },
                //     onClose: function(){
                //         alert('Anda menutup pop-up pembayaran.');
                //     }
                // });

                // Untuk saat ini, kita ikuti rute yang sudah Anda buat
                window.location.href = '{{ route('transaksi.pembayaran', $transaksi->id) }}';
            });
        }
    });
</script>
{{-- Pastikan Anda sudah menyertakan script Midtrans Snap jika ingin menggunakan pop-up langsung --}}
{{-- <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script> --}}
@endif
@endpush