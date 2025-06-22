@extends('layout.public')
@section('title', 'Dashboard Statistik')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Dashboard {{ Auth::user()->role == 'admin' ? 'Admin' : 'Penjual' }}</h2>
        @if(Auth::user()->role == 'penjual')
        <a href="{{ route('produk.create') }}" class="btn btn-primary rounded-pill px-4"><i class="fa fa-plus me-2"></i>Tambah Produk</a>
        @endif
    </div>

    <div class="row g-4 mb-5">
        {{-- (Kartu-kartu statistik dari jawaban sebelumnya tidak berubah, kodenya sudah benar) --}}
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fa fa-box-open fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Produk</p><h4 class="fw-bold mb-0">{{ $total_produk }}</h4></div></div></div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fa fa-exchange-alt fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Transaksi</p><h4 class="fw-bold mb-0">{{ $total_transaksi }}</h4></div></div></div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fa fa-star fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Ulasan</p><h4 class="fw-bold mb-0">{{ $total_ulasan }}</h4></div></div></div>
        </div>
        @if(Auth::check() && Auth::user()->role == 'penjual')
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fa fa-money-bill-wave fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Profit</p><h4 class="fw-bold mb-0">Rp {{ number_format($total_profit,0,',','.') }}</h4></div></div></div>
        </div>
        @endif
    </div>

    <div class="row g-4">
        <div class="{{ isset($status_data) ? 'col-lg-8' : 'col-lg-12' }}">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Grafik Transaksi per Bulan</h5>
                    <div class="position-relative" style="height:300px;">
                        <canvas id="chartTransaksi"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($status_data))
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Status Transaksi</h5>
                    <div class="position-relative" style="height:300px;">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===========================================
    // SCRIPT UNTUK LINE CHART (TRANSAKSI)
    // ===========================================
    const ctxTransaksi = document.getElementById('chartTransaksi');
    if (ctxTransaksi) {
        const labelsTransaksi = {!! json_encode(array_map(function($b){ return date('F', mktime(0,0,0,$b,1)); }, array_keys($grafik->toArray()))) !!};
        const dataTransaksi = {!! json_encode(array_values($grafik->toArray())) !!};
        new Chart(ctxTransaksi, {
            type: 'line',
            data: {
                labels: labelsTransaksi,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: dataTransaksi,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    }

    // ================================================================
    // SCRIPT UNTUK DOUGHNUT CHART (STATUS) - LOGIKA DIPERBAIKI
    // ================================================================
    // Hanya akan berjalan jika elemen canvas 'chartStatus' benar-benar ada di halaman
    const ctxStatus = document.getElementById('chartStatus');
    if (ctxStatus) {
        @if(isset($status_data))
            const dataStatus = [
                {{ $status_data['menunggu pembayaran'] ?? 0 }},
                {{ $status_data['diproses'] ?? 0 }},
                {{ $status_data['dikirim'] ?? 0 }},
                {{ $status_data['selesai'] ?? 0 }}
            ];
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai'],
                    datasets: [{
                        data: dataStatus,
                        backgroundColor: ['#6c757d', '#ffc107', '#17a2b8', '#10B981'],
                        borderWidth: 2
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 15 } } } }
            });
        @endif
    }
});
</script>
@endpush