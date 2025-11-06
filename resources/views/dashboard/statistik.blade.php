@extends('layout.public')
@section('title', 'Dashboard Statistik')

@push('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="fw-bold mb-0 text-secondary">Dashboard {{ Auth::user()->role == 'admin' ? 'Admin' : 'Penjual' }}</h2>
        @if(Auth::user()->role == 'penjual')
        <a href="{{ route('produk.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fa fa-plus me-2"></i>Tambah Produk</a>
        @endif
    </div>

    <p class="text-muted fs-5 mb-4">Selamat datang kembali, {{ Auth::user()->nama }}! 👋</p>


    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="fa fa-box-open fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Produk</p><h4 class="fw-bold mb-0">{{ number_format($total_produk) }}</h4></div></div></div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="fa fa-exchange-alt fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Transaksi</p><h4 class="fw-bold mb-0">{{ number_format($total_transaksi) }}</h4></div></div></div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="fa fa-star fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Ulasan</p><h4 class="fw-bold mb-0">{{ number_format($total_ulasan) }}</h4></div></div></div>
        </div>
        @if(Auth::check() && (Auth::user()->role == 'penjual' || Auth::user()->role == 'admin'))
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 h-100"><div class="card-body d-flex align-items-center p-4"><div class="flex-shrink-0 me-3"><div class="bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="fa fa-money-bill-wave fa-xl"></i></div></div><div><p class="text-muted mb-1">Total Profit</p><h4 class="fw-bold mb-0">Rp {{ number_format($total_profit,0,',','.') }}</h4></div></div></div>
        </div>
        @endif
    </div>

    <div class="row g-4">
        <div class="{{ isset($status_data) && count(array_filter($status_data)) > 0 ? 'col-lg-8' : 'col-lg-12' }}">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-secondary">Grafik Transaksi per Bulan (Tahun Ini)</h5>
                    <div class="position-relative" style="height:300px;">
                        <canvas id="chartTransaksi"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($status_data) && count(array_filter($status_data)) > 0)
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-secondary">Status Transaksi</h5>
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
    // Grafik Garis Transaksi
    const ctxTransaksi = document.getElementById('chartTransaksi');
    if (ctxTransaksi) {
        const labelsTransaksi = {!! json_encode(array_keys($grafik->toArray())) !!};
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
                    fill: true,
                    pointBackgroundColor: '#10B981',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                         callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) { label += context.parsed.y; }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                     y: {
                        beginAtZero: true,
                        ticks: {
                             stepSize: 1,
                             callback: function(value) {if (Number.isInteger(value)) {return value;}} // Hanya integer
                        }
                    }
                }
            }
        });
    }

    // ===============================================
    // ==  PERUBAHAN STATUS & WARNA ADA DI SINI      ==
    // ===============================================
    const ctxStatus = document.getElementById('chartStatus');
    if (ctxStatus) {
        @if(isset($status_data) && count(array_filter($status_data)) > 0)
            const dataValuesStatus = {!! json_encode(array_values($status_data)) !!};
            // Label disesuaikan dengan 4 status
            const dataLabelsStatus = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai'];
             // Warna disamakan dengan badge di halaman Pesanan Masuk
            const backgroundColors = [
                '#ffc107', // Menunggu Pembayaran (Kuning/Warning) - Sesuai badge warning-subtle
                '#fd7e14', // Diproses (Orange/Secondary color alternatif) - Sesuai badge warning-subtle (jika kuning dipakai menunggu)
                // ATAU Jika ingin 'Diproses' = Kuning: '#ffc107', dan 'Menunggu' = Abu '#6c757d'
                '#0dcaf0', // Dikirim (Biru Muda/Info) - Sesuai badge info-subtle
                '#198754', // Selesai (Hijau/Success) - Sesuai badge success-subtle
            ];

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: dataLabelsStatus,
                    datasets: [{
                        data: dataValuesStatus,
                        backgroundColor: backgroundColors, // Gunakan warna baru
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 15, usePointStyle: true, boxWidth: 10 }
                        },
                        tooltip: {
                             callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) { label += context.parsed; }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        @endif
    }
    // ===============================================
    // ==  AKHIR PERUBAHAN STATUS & WARNA          ==
    // ===============================================
});
</script>
@endpush