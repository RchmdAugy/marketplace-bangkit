<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Marketplace BANGKIT - @yield('title')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Style Umum -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fc;
        }
        .btn-primary {
            background-color: #ffffff;
            color: #1abc9c;
            border: none;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #f1f1f1;
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
