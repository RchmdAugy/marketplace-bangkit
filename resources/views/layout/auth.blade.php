<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Marketplace Bangkit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            transition: background 0.5s ease;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-title {
            font-weight: 700;
            color: #1abc9c;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .btn-primary, .btn-success {
            background-color: #1abc9c !important;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover, .btn-success:hover {
            background-color: #16a085 !important;
        }

        .btn-outline-primary {
            color: #1abc9c !important;
            border-color: #1abc9c !important;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #1abc9c !important;
            color: #fff !important;
        }

        .btn-outline-success {
            color: #16a085 !important;
            border-color: #16a085 !important;
            transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
            background: #16a085 !important;
            color: #fff !important;
        }

        .form-control:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 0 0.2rem rgba(26, 188, 156, 0.25);
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
        <footer>&copy; {{ date('Y') }} Marketplace Bangkit. s reserved.</footer>
    </div>
</body>
</html>
