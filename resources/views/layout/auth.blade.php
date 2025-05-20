
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Marketplace Bangkit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
            font-family: 'Poppins', sans-serif;
        }
        .auth-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(26,188,156,0.15);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-top: 80px;
        }
        .auth-title {
            font-weight: bold;
            color: #1abc9c;
            letter-spacing: 1px;
        }
        .btn-primary, .btn-success {
            background-color: #1abc9c !important;
            border: none;
        }
        .btn-primary:hover, .btn-success:hover {
            background-color: #16a085 !important;
        }
        .btn-outline-primary {
            color: #1abc9c !important;
            border-color: #1abc9c !important;
        }
        .btn-outline-primary:hover {
            background: #1abc9c !important;
            color: #fff !important;
            border-color: #1abc9c !important;
        }
        .btn-outline-success {
            color: #16a085 !important;
            border-color: #16a085 !important;
        }
        .btn-outline-success:hover {
            background: #16a085 !important;
            color: #fff !important;
            border-color: #16a085 !important;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>