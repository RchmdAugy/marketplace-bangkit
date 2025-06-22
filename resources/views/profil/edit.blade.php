@extends('layout.public')
@section('title', 'Edit Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-center mb-4">Edit Profil Akun</h3>

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="text-center mb-4">
                            <img id="image-preview" src="{{ $user->foto_profil ? asset('foto_profil/'.$user->foto_profil) : 'https://ui-avatars.com/api/?name='.$user->nama.'&background=10B981&color=fff&size=128' }}" alt="Foto Profil" class="img-fluid rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                            <div>
                                <label for="foto_profil" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="fa fa-upload me-1"></i> {{ Auth::user()->role == 'penjual' ? 'Ubah Logo Toko' : 'Ubah Foto Profil' }}
                                </label>
                                <input type="file" name="foto_profil" id="foto_profil" class="d-none" onchange="previewImage()">
                                <p class="text-muted small mt-2 mb-0">Max. 2MB (JPG, PNG)</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-semibold mb-3">Informasi Akun</h5>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Personal</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                        </div>
                        
                        @if($user->role == 'penjual')
                        <div class="mb-3">
                            <label for="nama_toko" class="form-label">Nama Toko</label>
                            <input type="text" name="nama_toko" id="nama_toko" class="form-control" value="{{ old('nama_toko', $user->nama_toko) }}" placeholder="Contoh: Warung Keripik Makmur">
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 08123456789">
                        </div>

                        @if($user->role == 'penjual')
                        <div class="mb-3">
                             <label for="alamat_toko" class="form-label">Alamat Toko</label>
                             <textarea name="alamat_toko" id="alamat_toko" class="form-control" rows="3" placeholder="Masukkan alamat lengkap toko Anda">{{ old('alamat_toko', $user->alamat_toko) }}</textarea>
                        </div>
                        @endif
                        
                        <hr class="my-4">

                        <h5 class="fw-semibold mb-3">Ubah Kata Sandi</h5>
                        <p class="text-muted small">Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi.</p>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="{{ route('profil.show') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">Batal</a>
                            <button class="btn btn-primary rounded-pill px-5 py-2 fw-bold" type="submit"><i class="fa fa-save me-2"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage() {
        const image = document.querySelector('#foto_profil');
        const imgPreview = document.querySelector('#image-preview');
        imgPreview.style.display = 'block'; // Pastikan gambar terlihat
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endpush