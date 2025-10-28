@extends('layout.public')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <i class="fa fa-shopping-cart fa-2x text-primary me-3"></i>
        <h2 class="fw-bold text-secondary mb-0">Keranjang Belanja Anda</h2>
    </div>

    {{-- Alert untuk pesan sukses/error (ditingkatkan dengan SweetAlert di layout.public) --}}
    {{-- Jika Anda masih ingin alert Bootstrap, Anda bisa pakai ini. Tapi SweetAlert lebih modern. --}}
    {{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif --}}

    @if($items->count())
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach($items as $item)
                <div class="card shadow-sm border-0 rounded-4 mb-3 keranjang-item-card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            {{-- Product Image --}}
                            <div class="col-md-2 col-3">
                                @php
                                    $imagePath = asset('foto_produk/' . $item->produk->foto);
                                    $defaultImage = asset('images/default-product.png'); // Pastikan Anda punya gambar default ini
                                @endphp
                                <div class="keranjang-img-wrapper rounded-3 overflow-hidden">
                                    @if($item->produk->foto && file_exists(public_path('foto_produk/' . $item->produk->foto)))
                                        <img src="{{ $imagePath }}" alt="{{ $item->produk->nama }}" class="img-fluid keranjang-product-image">
                                    @else
                                        <div class="keranjang-no-image bg-light text-muted d-flex align-items-center justify-content-center">
                                            <i class="fa fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Product Name & Seller --}}
                            <div class="col-md-4 col-9 mb-2 mb-md-0">
                                <h6 class="fw-semibold text-dark mb-1">{{ $item->produk->nama }}</h6>
                                <small class="text-muted d-block mb-1">Stok Tersedia: {{ $item->produk->stok }}</small>
                                <small class="text-muted">Oleh: <a href="{{ route('toko.show', $item->produk->user_id) }}" class="text-primary text-decoration-none">{{ $item->produk->user->nama_toko ?? $item->produk->user->nama }}</a></small>
                            </div>
                            
                            {{-- Quantity Control --}}
                            <div class="col-md-3 col-6">
                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex align-items-center quantity-form">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT"> {{-- Laravel expects PUT for update --}}
                                    <button type="button" class="btn btn-outline-secondary quantity-minus btn-qty-square">-</button>
                                    <input type="number" name="jumlah" value="{{ $item->jumlah }}" 
                                           min="1" max="{{ $item->produk->stok }}" 
                                           class="form-control text-center quantity-input" 
                                           data-item-id="{{ $item->id }}" {{-- Tambahkan data-item-id --}}
                                           style="width: 60px;">
                                    <button type="button" class="btn btn-outline-secondary quantity-plus btn-qty-square">+</button>
                                </form>
                            </div>
                            
                            {{-- Subtotal Price --}}
                            <div class="col-md-2 col-4 text-md-end">
                                <span class="fw-bold text-primary">Rp {{ number_format($item->produk->harga * $item->jumlah,0,',','.') }}</span>
                            </div>
                            
                            {{-- Remove Item Button --}}
                            <div class="col-md-1 col-2 text-end">
                                <form action="{{ route('keranjang.remove', $item->id) }}" method="POST" class="delete-form-keranjang">
                                    @csrf
                                    @method('DELETE') {{-- Gunakan DELETE method untuk hapus --}}
                                    <button type="submit" class="btn btn-sm btn-light text-danger-hover" title="Hapus Item">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Checkout Summary Card --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <form action="{{ route('keranjang.checkout') }}" method="POST">
                            @csrf
                            <h4 class="fw-bold text-secondary mb-4">Ringkasan Belanja</h4>
                            
                            <div class="mb-4">
                                <label for="alamat" class="form-label fw-semibold text-secondary">Alamat Lengkap Pengiriman</label>
                                <textarea name="alamat" id="alamat" class="form-control form-control-lg" rows="4" required 
                                          placeholder="Masukkan alamat lengkap Anda, termasuk nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota/kabupaten, dan kode pos.">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <hr class="my-4">
                            
                            @php
                                $grandTotal = $items->sum(function($item) {
                                    return $item->produk->harga * $item->jumlah;
                                });
                            @endphp
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Subtotal ({{ $items->sum('jumlah') }} produk)</span>
                                <span class="fw-medium text-secondary">Rp {{ number_format($grandTotal,0,',','.') }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                                <span>Total Bayar</span>
                                <span class="text-primary">Rp {{ number_format($grandTotal,0,',','.') }}</span>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                    <i class="fa fa-money-bill-wave me-2"></i> Lanjut ke Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart State --}}
        <div class="text-center py-5 my-5">
            <i class="fa fa-shopping-cart fa-7x text-border-color mb-4 animate__animated animate__bounceIn"></i>
            <h4 class="fw-bold text-secondary mb-2">Keranjang Anda masih kosong</h4>
            <p class="text-muted fs-6 mb-4">Yuk, isi dengan produk-produk UMKM favoritmu dan dukung produk lokal!</p>
            <a href="{{ route('produk.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold">
                <i class="fa fa-box-open me-2"></i> Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityForms = document.querySelectorAll('.quantity-form');

    quantityForms.forEach(form => {
        const minusBtn = form.querySelector('.quantity-minus');
        const plusBtn = form.querySelector('.quantity-plus');
        const input = form.querySelector('.quantity-input');
        const itemId = input.dataset.itemId; // Mengambil item ID dari data attribute
        let debounceTimer;

        const submitForm = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                // Menggunakan AJAX untuk update agar halaman tidak reload
                const formData = new FormData(form);
                formData.append('_method', 'PUT'); // Pastikan method PUT terkirim
                
                fetch(form.action, {
                    method: 'POST', // Fetch API akan menggunakan POST untuk _method=PUT
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Perbarui total harga di kartu item dan ringkasan
                        const cardBody = form.closest('.card-body');
                        cardBody.querySelector('.fw-bold.text-primary').textContent = `Rp ${data.new_subtotal.toLocaleString('id-ID')}`;
                        
                        // Perbarui grand total di ringkasan belanja
                        const grandTotalElement = document.querySelector('.d-flex.fw-bold.fs-5 .text-primary');
                        if (grandTotalElement) {
                            grandTotalElement.textContent = `Rp ${data.grand_total.toLocaleString('id-ID')}`;
                        }
                        const subtotalItemsElement = document.querySelector('.d-flex.justify-content-between.mb-3 .fw-medium.text-secondary');
                        if (subtotalItemsElement) {
                            subtotalItemsElement.textContent = `Rp ${data.grand_total.toLocaleString('id-ID')}`;
                        }
                        const subtotalCountElement = document.querySelector('.d-flex.justify-content-between.mb-3 .text-muted');
                        if (subtotalCountElement) {
                            subtotalCountElement.textContent = `Subtotal (${data.total_items_count} produk)`;
                        }

                        // Tampilkan sweetalert sukses (opsional, bisa dihilangkan jika terlalu sering)
                        // swal({
                        //     title: "Berhasil!",
                        //     text: "Jumlah produk berhasil diperbarui.",
                        //     icon: "success",
                        //     button: false,
                        //     timer: 1500
                        // });
                    } else {
                        swal({
                            title: "Gagal!",
                            text: data.message || "Gagal memperbarui jumlah produk.",
                            icon: "error",
                            button: "Coba Lagi",
                        });
                        // Kembalikan nilai input ke nilai sebelumnya jika gagal
                        input.value = data.old_jumlah; 
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal({
                        title: "Terjadi Kesalahan!",
                        text: "Tidak dapat menghubungi server. Coba lagi.",
                        icon: "error",
                        button: "Oke",
                    });
                });
            }, 500); // Tunggu 500ms sebelum mengirim AJAX
        };

        minusBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                submitForm();
            }
        });

        plusBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value);
            let maxStok = parseInt(input.getAttribute('max'));
            if (currentValue < maxStok) {
                input.value = currentValue + 1;
                submitForm();
            } else {
                swal({
                    title: "Stok Habis!",
                    text: "Jumlah maksimal yang bisa ditambahkan adalah stok produk yang tersedia.",
                    icon: "warning",
                    button: "Oke",
                });
            }
        });

        // Event listener untuk SweetAlert konfirmasi hapus
        document.querySelectorAll('.delete-form-keranjang').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form langsung dikirim

                swal({
                    title: "Hapus Item Ini?",
                    text: "Item ini akan dihapus dari keranjang belanja Anda.",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Batal",
                            value: null,
                            visible: true,
                            className: "swal-button swal-button--cancel",
                        },
                        confirm: {
                            text: "Ya, Hapus!",
                            value: true,
                            visible: true,
                            className: "swal-button swal-button--danger",
                        }
                    },
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.submit();
                    }
                });
            });
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    /* Custom CSS untuk Keranjang */
    .keranjang-item-card:hover {
        box-shadow: 0 8px 20px var(--shadow-medium) !important;
        transform: translateY(-3px);
    }
    .keranjang-img-wrapper {
        width: 100%;
        padding-top: 100%; /* Rasio 1:1 */
        position: relative;
        background-color: var(--light-bg-color);
        border: 1px solid var(--border-color);
    }
    .keranjang-product-image,
    .keranjang-no-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .keranjang-no-image {
        color: var(--border-color);
        font-size: 2.5rem;
    }

    /* Input Quantity di Keranjang */
    .quantity-form .form-control.quantity-input {
        border-color: var(--border-color);
        border-left: none;
        border-right: none;
        font-weight: 500;
        color: var(--secondary-color);
        height: 38px; /* Pastikan tinggi konsisten */
    }
    .quantity-form .btn.btn-outline-secondary.btn-qty-square {
        border-color: var(--border-color);
        color: var(--secondary-color);
        width: 38px; /* Lebar dan tinggi sama */
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all var(--transition-speed) ease;
    }
    .quantity-form .btn.btn-outline-secondary.btn-qty-square:hover {
        background-color: var(--light-bg-color);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    /* Rounded corners untuk tombol +- */
    .quantity-form .btn:first-of-type {
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }
    .quantity-form .btn:last-of-type {
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }

    /* Tombol hapus keranjang */
    .keranjang-item-card .btn.text-danger-hover {
        color: var(--secondary-color); /* Warna default agar tidak terlalu mencolok */
        transition: all var(--transition-speed) ease;
    }
    .keranjang-item-card .btn.text-danger-hover:hover {
        color: #EF4444 !important; /* Warna merah saat hover */
        background-color: #FEE2E2; /* Background merah muda saat hover */
    }

    /* Alamat form control */
    .form-control-lg {
        border-radius: 0.75rem; /* Sudut lebih bulat */
    }
    .form-control-lg:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
    }

    /* Placeholder text for empty cart */
    .text-border-color {
        color: var(--border-color);
    }
    .animate__bounceIn {
        animation-duration: 0.8s;
        animation-name: bounceIn;
    }
    @keyframes bounceIn {
        0% { transform: scale(0.3); opacity: 0; }
        50% { transform: scale(1.05); opacity: 1; }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); }
    }

    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .keranjang-img-wrapper {
            width: 80px; /* Ukuran gambar di mobile */
            padding-top: 80px;
        }
        .keranjang-product-image,
        .keranjang-no-image {
            object-fit: contain; /* Agar gambar tidak terpotong di mobile jika dimensinya aneh */
        }
        .keranjang-no-image {
            font-size: 1.5rem;
        }
        .quantity-form {
            justify-content: center; /* Tombol quantity di tengah di mobile */
            margin-top: 0.5rem;
        }
        .keranjang-item-card .row > div:nth-child(4), /* Harga */
        .keranjang-item-card .row > div:nth-child(5) { /* Hapus */
            text-align: center !important; /* Pusatkan harga dan hapus di mobile */
            margin-top: 1rem;
        }
    }
</style>
{{-- Membutuhkan animate.css untuk efek bounceIn, jika belum ada di public.blade.php --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/> --}}
@endpush