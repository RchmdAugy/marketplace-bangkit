@extends('layout.public')
@section('title', 'Detail Transaksi #'.$transaksi->id)

{{-- Tambahkan Font Awesome Brands jika belum ada (untuk ikon WhatsApp) --}}
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10"> {{-- Lebarkan sedikit container utama --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2"><i class="fa fa-arrow-left me-2"></i> Kembali ke Daftar Transaksi</a>
                @if(in_array($transaksi->status, ['diproses', 'dikirim', 'selesai'])) {{-- 'diproses' juga bisa cetak --}}
                    <a class="btn btn-primary rounded-pill px-4 py-2" href="{{ route('transaksi.invoice', $transaksi->id) }}" target="_blank"><i class="fa fa-file-pdf me-2"></i> Cetak Invoice</a>
                @endif
            </div>

            <div class="card shadow-lg border-0 rounded-4 mb-4"> {{-- Shadow lebih kuat --}}
                <div class="card-header bg-white border-bottom-0 p-4 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2"> {{-- Tambah flex-wrap untuk responsif --}}
                        <div>
                            <h3 class="fw-bold text-secondary mb-1">Detail Transaksi</h3>
                            <p class="text-primary fw-medium mb-0">#INV{{ $transaksi->id }}</p>
                        </div>
                        <span class="badge fs-6 px-3 py-2 rounded-pill text-capitalize 
                            @switch($transaksi->status)
                                @case('selesai') bg-success text-white @break
                                @case('dikirim') bg-info text-white @break
                                @case('diproses') bg-success text-white @break {{-- Ganti jadi success agar seragam dengan 'selesai' --}}
                                @case('menunggu pembayaran') bg-warning text-dark @break {{-- Ganti jadi warning --}}
                                @case('dibatalkan') bg-danger text-white @break
                                @case('pending') bg-secondary text-white @break
                                @default bg-secondary text-white
                            @endswitch">
                            
                            {{-- Icon yang Sesuai Status --}}
                            @switch($transaksi->status)
                                @case('selesai') <i class="fas fa-check-circle me-2"></i> @break
                                @case('dikirim') <i class="fas fa-truck me-2"></i> @break
                                @case('diproses') <i class="fas fa-sync-alt fa-spin me-2"></i> @break
                                @case('menunggu pembayaran') <i class="fas fa-hourglass-half me-2"></i> @break
                                @case('dibatalkan') <i class="fas fa-times-circle me-2"></i> @break
                                @default <i class="fas fa-circle-dot me-2" style="font-size: 0.7em;"></i>
                            @endswitch
                            
                            {{ str_replace('_', ' ', $transaksi->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5"> {{-- Padding responsif --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block mb-1">Tanggal Transaksi</strong>
                            <p class="mb-0 text-dark">{{ $transaksi->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block mb-1">Pembeli</strong>
                            <p class="mb-0 text-dark">{{ $transaksi->user->nama }}</p>
                        </div>
                        <div class="col-12 mt-3">
                            <strong class="text-muted d-block mb-1">Alamat Pengiriman</strong>
                            {{-- Gunakan nl2br untuk menghormati baris baru dari textarea --}}
                            <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $transaksi->alamat_pengiriman }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-4 text-secondary">Produk yang Dipesan</h5>
                    <div class="list-group list-group-flush border-bottom mb-4">
                    @foreach($transaksi->details as $detail)
                        <div class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                @php
                                    $imagePath = null;
                                    if ($detail->produk) {
                                        if ($detail->produk->foto && file_exists(public_path('foto_produk/' . $detail->produk->foto))) {
                                            $imagePath = asset('foto_produk/' . $detail->produk->foto);
                                        } elseif ($detail->produk->images->first() && file_exists(public_path('foto_produk_gallery/' . $detail->produk->images->first()->image_path))) {
                                            $imagePath = asset('foto_produk_gallery/' . $detail->produk->images->first()->image_path);
                                        }
                                    }
                                @endphp

                                @if($imagePath)
                                    <img src="{{ $imagePath }}" alt="{{ $detail->produk->nama ?? 'Produk' }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light rounded me-3" style="width: 70px; height: 70px;"><i class="fas fa-image text-muted fs-4"></i></div>
                                @endif

                                <div>
                                    <h6 class="fw-bold mb-1">{{ $detail->produk->nama ?? 'Produk Telah Dihapus' }}</h6>
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
                            <a href="{{ route('transaksi.pembayaran', $transaksi->id) }}" id="payButton" class="btn btn-warning rounded-pill btn-lg py-3 fw-bold"><i class="fa fa-credit-card me-2"></i> Lanjutkan Pembayaran</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- =============================================== --}}
            {{-- ==  BAGIAN KONFIRMASI WHATSAPP (BARU)       == --}}
            {{-- =============================================== --}}
            @if(isset($pesanWhatsapp) && $pesanWhatsapp)
                <div class="alert alert-success shadow-sm rounded-4 p-4 p-md-5 mb-4" role="alert" style="border-left: 5px solid #198754;">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle fa-3x me-4 text-success"></i>
                        <div>
                            <h4 class="alert-heading fw-bold">Pembayaran Berhasil!</h4>
                            <p class="mb-0 lead">Pesanan Anda telah kami terima. Mohon konfirmasi pesanan Anda ke PLUT.</p>
                        </div>
                    </div>
                    <p class="text-muted">
                        Silakan kirim konfirmasi pesanan beserta detail alamat ke pihak PLUT melalui WhatsApp agar pesanan Anda dapat segera diproses oleh penjual.
                    </p>
                    <hr>
                    <div class="text-center">
                        <a href="{{ $pesanWhatsapp }}" class="btn btn-success btn-lg rounded-pill fw-bold px-5 py-3" target="_blank" style="background-color: #25D366; border-color: #25D366;">
                            <i class="fab fa-whatsapp me-2"></i> Kirim Konfirmasi ke PLUT
                        </a>
                    </div>
                </div>
            @endif
            {{-- =============================================== --}}
            {{-- ==  AKHIR BAGIAN WHATSAPP                  == --}}
            {{-- =============================================== --}}


            {{-- Informasi Status (Tetap ada) --}}
            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4 text-secondary">Riwayat Status</h5>
                    <ul class="list-unstyled mb-0">
                        @if($transaksi->status == 'menunggu pembayaran' || $transaksi->status == 'pending')
                            <li><i class="fas fa-hourglass-half text-warning me-2"></i> Mohon selesaikan pembayaran Anda.</li>
                        @elseif($transaksi->status == 'diproses')
                            <li><i class="fas fa-check-circle text-success me-2"></i> Pembayaran berhasil pada {{ $transaksi->updated_at->format('d M Y, H:i') }}.</li>
                            <li><i class="fas fa-sync-alt text-info me-2 mt-2"></i> Pesanan Anda sedang disiapkan oleh penjual.</li>
                        @elseif($transaksi->status == 'dikirim')
                             <li><i class="fas fa-check-circle text-success me-2"></i> Pembayaran berhasil.</li>
                             <li><i class="fas fa-sync-alt text-info me-2 mt-2"></i> Pesanan telah disiapkan.</li>
                             <li><i class="fas fa-truck text-primary me-2 mt-2"></i> Pesanan Anda telah dikirim.</li>
                            @if($transaksi->nomor_resi)
                                <li class="mt-2"><i class="fas fa-barcode text-dark me-2"></i> No. Resi: <span class="fw-semibold">{{ $transaksi->nomor_resi }}</span></li>
                            @endif
                        @elseif($transaksi->status == 'selesai')
                            <li><i class="fas fa-check-circle text-success me-2"></i> Pesanan Anda telah selesai. Terima kasih!</li>
                        @elseif($transaksi->status == 'dibatalkan')
                             <li><i class="fas fa-times-circle text-danger me-2"></i> Pesanan ini telah dibatalkan.</li>
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
{{-- Script untuk tombol "Lanjutkan Pembayaran" (tidak berubah) --}}
@if($transaksi->status == 'menunggu pembayaran' && Auth::id() == $transaksi->user_id && $transaksi->snap_token)
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('payButton');
        if (payButton) {
            payButton.addEventListener('click', function (e) {
                e.preventDefault(); // Hentikan link default
                window.location.href = '{{ route('transaksi.pembayaran', $transaksi->id) }}';
            });
        }
    });
</script>
@endif
@endpush