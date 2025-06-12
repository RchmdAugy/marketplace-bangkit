@extends('layout.public')
@section('title', 'Dashboard Statistik')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Dashboard Statistik</h2>

    <!-- Card Informasi -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-lg border-0 rounded-4 text-center py-4 bg-primary text-white">
                <div class="mb-2">
                    <i class="fa fa-box-open fa-2x"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $total_produk }}</h3>
                <div class="fw-semibold">Total Produk</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-lg border-0 rounded-4 text-center py-4 bg-success text-white">
                <div class="mb-2">
                    <i class="fa fa-exchange-alt fa-2x"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $total_transaksi }}</h3>
                <div class="fw-semibold">Total Transaksi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-lg border-0 rounded-4 text-center py-4 bg-warning text-dark">
                <div class="mb-2">
                    <i class="fa fa-star fa-2x"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $total_ulasan }}</h3>
                <div class="fw-semibold">Total Ulasan</div>
            </div>
        </div>
        @if(Auth::check() && Auth::user()->role == 'penjual')
        <div class="col-md-3">
            <div class="card shadow-lg border-0 rounded-4 text-center py-4 bg-info text-white">
                <div class="mb-2">
                    <i class="fa fa-money-bill-wave fa-2x"></i>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($total_profit,0,',','.') }}</h3>
                <div class="fw-semibold">Total Profit</div>
            </div>
        </div>
        @endif
    </div>

    <!-- Grafik -->
    <div class="row g-4">
        <!-- Grafik Transaksi -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">
                        <i class="fa fa-chart-line me-2"></i>Grafik Transaksi per Bulan
                    </h4>
                    <canvas id="chartTransaksi" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Transaksi -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">
                        <i class="fa fa-chart-pie me-2"></i>Status Transaksi
                    </h4>
                    <canvas id="chartStatus" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Debugging: Check if canvas elements exist
console.log('chartTransaksi element:', document.getElementById('chartTransaksi'));
console.log('chartStatus element:', document.getElementById('chartStatus'));

// Grafik Transaksi
const ctxTransaksi = document.getElementById('chartTransaksi').getContext('2d');
const chartTransaksi = new Chart(ctxTransaksi, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_map(function($b){ return date('F', mktime(0,0,0,$b,1)); }, array_keys($grafik->toArray()))) !!},
        datasets: [{
            label: 'Jumlah Transaksi',
            data: {!! json_encode(array_values($grafik->toArray())) !!},
            borderColor: '#1abc9c',
            backgroundColor: 'rgba(26, 188, 156, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { 
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Debugging: Log status_data received
console.log('status_data:', {
    menunggu_pembayaran: {{ isset($status_data['menunggu pembayaran']) ? $status_data['menunggu pembayaran'] : 0 }},
    diproses: {{ isset($status_data['diproses']) ? $status_data['diproses'] : 0 }},
    dikirim: {{ isset($status_data['dikirim']) ? $status_data['dikirim'] : 0 }},
    selesai: {{ isset($status_data['selesai']) ? $status_data['selesai'] : 0 }}
});

// Grafik Status Transaksi
const ctxStatus = document.getElementById('chartStatus').getContext('2d');
const chartStatus = new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
        labels: ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai'],
        datasets: [{
            data: [
                {{ isset($status_data['menunggu pembayaran']) ? $status_data['menunggu pembayaran'] : 0 }},
                {{ isset($status_data['diproses']) ? $status_data['diproses'] : 0 }},
                {{ isset($status_data['dikirim']) ? $status_data['dikirim'] : 0 }},
                {{ isset($status_data['selesai']) ? $status_data['selesai'] : 0 }}
            ],
            backgroundColor: [
                '#6c757d', // Menunggu Pembayaran - Abu-abu
                '#ffc107', // Diproses - Kuning
                '#17a2b8', // Dikirim - Biru
                '#28a745'  // Selesai - Hijau
            ],
            borderWidth: 0
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = Math.round((value / total) * 100);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        },
        cutout: '70%'
    }
});
</script>
@endpush