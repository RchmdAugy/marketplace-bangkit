
@extends('layout.public')
@section('title', 'Dashboard Statistik')

@section('content')
<h2 class="mb-4 fw-bold text-primary text-center border-bottom pb-2">Dashboard Statistik</h2>


<div class="row mb-4 g-4">
    <div class="col-md-3">
        <div class="card shadow border-0 rounded-4 text-center py-4 bg-primary text-white">
            <div class="mb-2">
                <i class="fa fa-box-open fa-2x"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $total_produk }}</h3>
            <div class="fw-semibold">Jumlah Produk</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-0 rounded-4 text-center py-4 bg-success text-white">
            <div class="mb-2">
                <i class="fa fa-exchange-alt fa-2x"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $total_transaksi }}</h3>
            <div class="fw-semibold">Jumlah Transaksi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-0 rounded-4 text-center py-4 bg-warning text-dark">
            <div class="mb-2">
                <i class="fa fa-star fa-2x"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $total_ulasan }}</h3>
            <div class="fw-semibold">Jumlah Ulasan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-0 rounded-4 text-center py-4 bg-info text-white">
            <div class="mb-2">
                <i class="fa fa-money-bill-wave fa-2x"></i>
            </div>
            <h3 class="fw-bold mb-0">Rp {{ number_format($total_profit,0,',','.') }}</h3>
            <div class="fw-semibold">Total Profit</div>
        </div>
    </div>
</div>

<div class="card shadow border-0 rounded-4 mt-4">
    <div class="card-body">
        <h4 class="fw-bold text-primary mb-3"><i class="fa fa-chart-bar me-2"></i>Grafik Transaksi per Bulan</h4>
        <canvas id="chart" height="100"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_map(function($b){ return date('F', mktime(0,0,0,$b,1)); }, array_keys($grafik->toArray()))) !!},
            datasets: [{
                label: 'Jumlah Transaksi',
                data: {!! json_encode(array_values($grafik->toArray())) !!},
                backgroundColor: '#1abc9c',
                borderRadius: 8,
                maxBarThickness: 40
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection