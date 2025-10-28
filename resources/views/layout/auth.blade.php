<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace BANGKIT - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #10B981; /* Warna utama marketplace Anda (Emerald-500) */
            --primary-dark-color: #059669;
            --secondary-color: #475569; /* Slate-600 */
            --light-bg-color: #F8FAFC; /* Slate-50 */
            --border-color: #E2E8F0; /* Slate-200 */
            /* Warna untuk gradien background */
            --gradient-green: #10B981; /* Hijau cerah */
            --gradient-yellow: #FACC15; /* Kuning terang */
            --gradient-blue: #3B82F6; /* Biru cerah */
        }
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--light-bg-color);
            padding: 1.5rem;
        }
        .auth-card {
            display: flex;
            width: 100%;
            max-width: 950px;
            min-height: 650px;
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .auth-showcase {
            /* Perubahan utama di sini: Menggunakan linear-gradient */
            background: linear-gradient(
                135deg, /* Arah gradien */
                var(--gradient-green) 0%, /* Hijau di awal */
                var(--gradient-yellow) 50%, /* Kuning di tengah */
                var(--gradient-blue) 100% /* Biru di akhir */
            );
            
            position: relative;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Teks di bagian bawah */
            padding: 3rem;
            align-items: flex-start; /* Mengatur item ke kiri */
        }
        /* Overlay ::before mungkin tidak diperlukan lagi, atau bisa disesuaikan */
        .auth-showcase::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            /* Tambahkan overlay sangat ringan untuk kontras teks jika diperlukan */
            background: linear-gradient(to top, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0) 100%);
            /* Atau hapus blok ini jika teks sudah cukup terbaca */
        }
        .auth-showcase > * {
            position: relative;
            z-index: 2;
        }
        .auth-showcase .logo-container {
            position: absolute;
            top: 3rem;
            left: 3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .auth-showcase .logo-container .fa-store {
            font-size: 1.5rem;
        }
        .auth-showcase .logo-container span {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .auth-showcase h2 {
            font-weight: 700;
            font-size: 2.5rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .auth-showcase p {
            font-size: 1rem;
            line-height: 1.5;
            max-width: 85%;
            color: rgba(255, 255, 255, 0.85); /* Agar teks deskripsi sedikit transparan */
        }

        .auth-form-container {
            padding: 2rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }
        .form-control {
            border: 1px solid var(--border-color);
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.8rem;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark-color);
            border-color: var(--primary-dark-color);
        }
        .alert ul {
            margin-bottom: 0;
            padding-left: 1.2rem;
        }
        @media (max-width: 767px) {
            .auth-showcase {
                display: none;
            }
            .auth-form-container {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="col-md-5 d-none d-md-flex auth-showcase">
            <div class="logo-container text-white">
                <i class="fa fa-store"></i>
                <span>BANGKIT</span>
            </div>
            <div>
                <h2 class="mb-3">@yield('showcase-title', 'Mulai Petualangan Belanja Anda')</h2>
                <p>Dukung UMKM lokal dan temukan produk unik berkualitas langsung dari pembuatnya.</p>
            </div>
        </div>
        
        <div class="col-12 col-md-7 auth-form-container">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>