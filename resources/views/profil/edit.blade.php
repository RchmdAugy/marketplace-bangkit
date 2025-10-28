@extends('layout.public')
@section('title', 'Edit Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10"> {{-- Lebar kolom yang lebih responsif --}}
            <div class="card shadow-lg border-0 rounded-4"> {{-- Shadow lebih kuat untuk penekanan --}}
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-center mb-5 text-secondary">
                        <i class="fa fa-user-circle me-2"></i> Edit Profil Akun
                    </h3>

                    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Bagian Foto Profil / Logo Toko --}}
                        <div class="text-center mb-5">
                            <div class="position-relative d-inline-block"> {{-- Wrapper untuk posisi ikon edit --}}
                                <img id="image-preview" 
                                     src="{{ $user->foto_profil ? asset('foto_profil/'.$user->foto_profil) : 'https://ui-avatars.com/api/?name='.$user->nama.'&background=10B981&color=fff&size=128' }}" 
                                     alt="Foto Profil" 
                                     class="img-fluid rounded-circle shadow-lg profile-avatar" {{-- Tambah class profile-avatar --}}
                                     style="width: 140px; height: 140px; object-fit: cover;"> {{-- Ukuran lebih besar --}}
                                
                                <label for="foto_profil" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-2 me-2 mb-2 upload-button-avatar" title="{{ Auth::user()->role == 'penjual' ? 'Ubah Logo Toko' : 'Ubah Foto Profil' }}"> {{-- Tombol di kanan bawah avatar --}}
                                    <i class="fa fa-camera fa-lg"></i>
                                </label>
                                <input type="file" name="foto_profil" id="foto_profil" class="d-none" onchange="previewImage()">
                            </div>
                            <p class="text-muted small mt-3 mb-0">Max. 2MB (JPG, PNG)</p>
                            @error('foto_profil')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="my-5 border-secondary opacity-25"> {{-- Garis pemisah lebih menonjol --}}

                        <h5 class="fw-bold mb-4 text-primary"><i class="fa fa-info-circle me-2"></i> Informasi Akun</h5>
                        
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-medium">Nama Personal</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-lg" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        @if($user->role == 'penjual')
                        <div class="mb-4">
                            <label for="nama_toko" class="form-label fw-medium">Nama Toko</label>
                            <input type="text" name="nama_toko" id="nama_toko" class="form-control form-control-lg" value="{{ old('nama_toko', $user->nama_toko) }}" placeholder="Contoh: Warung Keripik Makmur">
                            @error('nama_toko')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @endif

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="no_telepon" class="form-label fw-medium">Nomor Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control form-control-lg" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 08123456789">
                            @error('no_telepon')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if($user->role == 'penjual')
                        <div class="mb-4">
                            <label for="alamat_toko" class="form-label fw-medium">Alamat Toko</label>
                            <textarea name="alamat_toko" id="alamat_toko" class="form-control form-control-lg" rows="3" placeholder="Masukkan alamat lengkap toko Anda">{{ old('alamat_toko', $user->alamat_toko) }}</textarea>
                            @error('alamat_toko')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @endif
                        
                        <hr class="my-5 border-secondary opacity-25">

                        <h5 class="fw-bold mb-4 text-primary"><i class="fa fa-lock me-2"></i> Ubah Kata Sandi</h5>
                        <p class="text-muted small mb-4">Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi.</p>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg">
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-end mt-4"> {{-- Flexbox untuk tombol, responsif --}}
                            <a href="{{ route('profil.show') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 order-2 order-md-1">Batal</a>
                            <button class="btn btn-primary rounded-pill px-5 py-2 fw-bold order-1 order-md-2" type="submit"><i class="fa fa-save me-2"></i> Simpan Perubahan</button>
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
        const imageInput = document.querySelector('#foto_profil');
        const imgPreview = document.querySelector('#image-preview');
        
        if (imageInput.files && imageInput.files[0]) {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(imageInput.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        } else {
            // Jika file dihapus atau tidak dipilih, kembalikan ke avatar default atau yang sudah ada
            // Ini akan memerlukan nilai default dari backend atau data lama
            const defaultAvatar = '{{ $user->foto_profil ? asset('foto_profil/'.$user->foto_profil) : 'https://ui-avatars.com/api/?name='.$user->nama.'&background=10B981&color=fff&size=128' }}';
            imgPreview.src = defaultAvatar;
        }
    }
</script>
@endpush