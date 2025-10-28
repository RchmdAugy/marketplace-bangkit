@extends('layout.public')
@section('title', 'Beri Ulasan')

@push('css')
<style>
    .star-rating {
        display: flex; /* Normal, kiri ke kanan */
        justify-content: flex-start;
        font-size: 2rem;
        gap: 2px;
    }
    .star-rating input {
        display: none; /* Sembunyikan radio button */
    }
    .star-rating label {
        cursor: pointer;
        transition: color 0.2s ease;
        padding: 0 3px;
    }

    /* Target 'i' (ikon bintang) di dalamnya */
    .star-rating label i {
        color: #ddd; /* Default abu-abu */
        transition: color 0.2s ease;
    }

    /* Target 'i' tag di dalam label yang punya kelas .hover atau .selected */
    .star-rating label.hover i,
    .star-rating label.selected i {
        color: #ffc107; /* Warna kuning */
    }
</style>
@endpush


@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Beri Ulasan untuk Pesanan #{{ $transaksi->id }}</h2>
                <p class="text-muted">Bagikan pengalaman Anda tentang produk yang telah Anda beli.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <h5 class="alert-heading fs-6 fw-bold mb-2"><i class="fa fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @foreach($transaksi->details as $detail)
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        
                        {{-- =================================== --}}
                        {{-- ==  BAGIAN FOTO YANG DIPERBAIKI  == --}}
                        {{-- == (storage/ dihapus dari src)  == --}}
                        {{-- =================================== --}}
                        <img src="{{ asset('foto_produk/'.$detail->produk->foto) }}" class="rounded-3 me-4" style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $detail->produk->nama }}">
                        {{-- =================================== --}}

                        <div>
                            <h5 class="fw-semibold mb-0 text-dark">{{ $detail->produk->nama }}</h5>
                            <small class="text-muted">Dibeli pada {{ $transaksi->created_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                    
                    <hr class="my-3"> 

                    @php
                        $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                                              ->where('transaksi_id', $transaksi->id)
                                                              ->where('produk_id', $detail->produk->id)
                                                              ->first();
                    @endphp

                    @if($existingReview)
                        <div class="alert alert-success d-flex align-items-center rounded-4" role="alert">
                            <i class="fa fa-check-circle text-success me-2 fs-5"></i>
                            <div>
                                Anda sudah memberikan ulasan untuk produk ini.
                                <br>
                                <span class="fw-bold">Rating:</span> 
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $existingReview->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="ms-2 text-muted">"{{ $existingReview->komentar }}"</span>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('review.store', $transaksi->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $detail->produk->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium text-dark">Rating Anda:</label>
                                <div class="star-rating" data-rating-group="product-{{$detail->produk->id}}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="{{$i}}-stars-{{$detail->produk->id}}" name="rating_{{$detail->produk->id}}" value="{{$i}}" required/>
                                        <label for="{{$i}}-stars-{{$detail->produk->id}}" data-value="{{$i}}"><i class="fa fa-star"></i></label>
                                    @endfor
                                </div>
                                @error("rating_{$detail->produk->id}")
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="komentar-{{$detail->produk->id}}" class="form-label fw-medium text-dark">Komentar Anda:</label>
                                <textarea name="komentar_{{$detail->produk->id}}" id="komentar-{{$detail->produk->id}}" class="form-control @error("komentar_{$detail->produk->id}") is-invalid @enderror" rows="3" required placeholder="Bagaimana pengalaman Anda dengan produk ini? Apa yang Anda suka/tidak suka?"></textarea>
                                @error("komentar_{$detail->produk->id}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end mt-4">
                                <button class="btn btn-primary rounded-pill px-4" type="submit">
                                    <i class="fa fa-paper-plane me-2"></i> Kirim Ulasan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
            <div class="text-center mt-4">
                <a class="btn btn-outline-secondary rounded-pill px-5" href="{{ route('transaksi.index') }}">Kembali ke Riwayat Transaksi</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const starRatingGroups = document.querySelectorAll('.star-rating');
    starRatingGroups.forEach(group => {
        const labels = group.querySelectorAll('label');
        const inputs = group.querySelectorAll('input[type="radio"]');
        let checkedValue = 0; 
        function setRatingVisual(value, isSelected) {
            labels.forEach(label => {
                const starValue = parseInt(label.dataset.value);
                const className = isSelected ? 'selected' : 'hover';
                if (starValue <= value) {
                    label.classList.add(className);
                } else {
                    label.classList.remove(className);
                }
            });
        }
        function resetHover() {
            labels.forEach(label => {
                label.classList.remove('hover');
            });
        }
        inputs.forEach(input => {
            if (input.checked) {
                checkedValue = parseInt(input.value);
                setRatingVisual(checkedValue, true); 
            }
        });
        labels.forEach(label => {
            label.addEventListener('mouseover', () => {
                resetHover(); 
                setRatingVisual(parseInt(label.dataset.value), false); 
            });
            group.addEventListener('mouseout', () => {
                resetHover(); 
                setRatingVisual(checkedValue, true); 
            });
            label.addEventListener('click', () => {
                const radio = document.getElementById(label.getAttribute('for'));
                if (radio) {
                    checkedValue = parseInt(radio.value); 
                    labels.forEach(lbl => {
                        lbl.classList.remove('selected', 'hover');
                    });
                    setRatingVisual(checkedValue, true);
                }
            });
        });
    });
});
</script>
@endpush