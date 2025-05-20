@extends('layout.public')
@section('title', 'Dashboard Statistik')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Dashboard Statistik</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center bg-primary text-white">
            <h3>{{ $total_produk }}</h3>
            <p>Jumlah Produk</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center bg-success text-white">
            <h3>{{ $total_transaksi }}</h3>
            <p>Jumlah Transaksi</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center bg-warning text-dark">
            <h3>{{ $total_ulasan }}</h3>
            <p>Jumlah Ulasan</p>
        </div>
    </div>
</div>

<div class="card">
    <h4>Grafik Transaksi per Bulan</h4>
    <canvas id="chart" height="100"></canvas>
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
                backgroundColor: '#1abc9c'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
