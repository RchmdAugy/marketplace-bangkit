@extends('layout.public')
@section('title', 'Beri Ulasan')

@section('content')
<h2 class="border-bottom pb-2 mb-3 fw-bold">Beri Ulasan untuk Produk</h2>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('review.store', $transaksi->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="produk_id" class="form-label">Pilih Produk:</label>
        <select name="produk_id" id="produk_id" class="form-select rounded-3" required>
            <option value="">-- Pilih Produk --</option>
            @foreach($transaksi->details as $detail)
                <option value="{{ $detail->produk->id }}">
                    {{ $detail->produk->nama ?? '-' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="rating" class="form-label">Rating (1-5):</label>
        <input type="number" name="rating" id="rating" min="1" max="5" required class="form-control rounded-3">
    </div>
    <div class="mb-3">
        <label for="komentar" class="form-label">Komentar:</label>
        <textarea name="komentar" id="komentar" required class="form-control rounded-3" rows="4"></textarea>
    </div>
    <div class="d-flex gap-2 justify-content-center">
        <button class="btn btn-primary rounded-pill px-4 fw-bold py-2" type="submit"><i class="fa fa-paper-plane me-2"></i> Kirim Ulasan</button>
        <a class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2" href="{{ route('transaksi.index') }}"><i class="fa fa-arrow-left me-2"></i> Batal</a>
    </div>
</form>
@endsection