@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="fa fa-box"></i> Total Produk</h5>
                <p class="fs-4">{{ $totalProduk }}</p>
            </div>
        </div>
    </div>
    <!-- Tambah lainnya: pesanan, pengguna, dsb -->
</div>
@endsection
