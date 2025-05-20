@extends('layout.public')
@section('title', 'Beri Ulasan')

@section('content')
<h2 class="border-bottom pb-2 mb-3">Beri Ulasan untuk {{ $transaksi->produk->nama }}</h2>

<form action="{{ route('review.store', $transaksi->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="form-label">Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Komentar:</label>
        <textarea name="komentar" required class="form-control"></textarea>
    </div>
    <button class="btn btn-primary btn-sm" type="submit">Kirim Ulasan</button>
    <a class="btn btn-primary btn-sm" href="{{ route('transaksi.index') }}">Batal</a>
</form>
@endsection
