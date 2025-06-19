<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Marketplace Bangkit</title>
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
            background-image: url('https://images.pexels.com/photos/39284/macbook-apple-imac-computer-39284.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
            background-size: cover;
            background-position: center;
            position: relative;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Teks di bagian bawah */
            padding: 3rem;
        }
        .auth-showcase::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to top, rgba(16, 185, 129, 0.9) 0%, rgba(5, 150, 105, 0.7) 100%); /* Overlay warna primer */
        }
        .auth-showcase > * {
            position: relative;
            z-index: 2;
        }
        .auth-showcase h2 {
            font-weight: 700;
            font-size: 2.5rem;
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
            <div>
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4 mb-4 text-white" href="{{ route('home') }}">
                    <i class="fa fa-store fa-lg"></i>
                    <span style="letter-spacing:1px;">BANGKIT</span>
                </a>
                <h2 class="mb-3">@yield('showcase-title', 'Mulai Petualangan Belanja Anda')</h2>
                <p class="text-white-50">Dukung UMKM lokal dan temukan produk unik berkualitas langsung dari pembuatnya.</p>
            </div>
        </div>
        
        <div class="col-12 col-md-7 auth-form-container">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>