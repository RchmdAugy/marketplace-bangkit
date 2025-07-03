@extends('layout.auth')

@section('title', 'Daftar Akun')
@section('showcase-title', 'Bergabung dengan Ribuan UMKM Hebat')

@section('content')
    <div class="w-100">
        <h3 class="fw-bold mb-1">Daftar Akun Baru</h3>
        <p class="text-muted mb-4">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--primary-color); font-weight: 500;">Masuk di sini</a></p>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label fw-medium">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Nama Anda">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@gmail.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 8 Karakter" minlength="8">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label fw-medium">Saya ingin mendaftar sebagai:</label>
                <select name="role" id="role" class="form-select" style="padding: 0.8rem 1rem;" required>
                    <option value="pembeli" @if(old('role') == 'pembeli') selected @endif>Pembeli</option>
                    <option value="penjual" @if(old('role') == 'penjual') selected @endif>Penjual (UMKM)</option>
                </select>
            </div>

            <div id="form-penjual-lanjutan" style="display: none;">
                <hr class="my-4">
                <h5 class="fw-semibold mb-3">Verifikasi Penjual</h5>
                <p class="text-muted small">Untuk menjaga kualitas, kami memerlukan verifikasi lisensi usaha Anda (NIB, PIRT, Halal, dll).</p>
                <div class="mb-3">
                    <label for="nomor_lisensi" class="form-label fw-medium">Nomor Lisensi Usaha</label>
                    <input type="text" name="nomor_lisensi" id="nomor_lisensi" class="form-control" value="{{ old('nomor_lisensi') }}" placeholder="Masukkan nomor lisensi Anda">
                </div>
                <div class="mb-4">
                    <label for="file_lisensi" class="form-label fw-medium">Unggah Dokumen Lisensi</label>
                    <input type="file" name="file_lisensi" id="file_lisensi" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <div class="form-text">File dapat berupa PDF, JPG, atau PNG (Maksimal 2MB).</div>
                </div>
            </div>
            
            <div class="d-grid mt-4">
                <button class="btn btn-primary w-100 fw-bold py-2" type="submit"><i class="fa fa-user-plus me-2"></i> Daftar Akun</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const formPenjual = document.getElementById('form-penjual-lanjutan');
    const inputLisensi = document.getElementById('nomor_lisensi');
    const inputFile = document.getElementById('file_lisensi');

    function toggleFormPenjual() {
        if (roleSelect.value === 'penjual') {
            formPenjual.style.display = 'block';
            inputLisensi.required = true;
            inputFile.required = true;
        } else {
            formPenjual.style.display = 'none';
            inputLisensi.required = false;
            inputFile.required = false;
        }
    }

    // Panggil saat halaman dimuat untuk memeriksa nilai awal (jika ada old value)
    toggleFormPenjual();

    // Panggil setiap kali pilihan berubah
    roleSelect.addEventListener('change', toggleFormPenjual);
});
</script>
@endpush