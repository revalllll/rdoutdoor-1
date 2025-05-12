<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDOutdoor | Petualangan Dimulai di Sini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
              url('https://images.unsplash.com/uploads/141148589884100082977/a816dbd7?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 1.2rem;
            color: #ddd;
            margin-bottom: 30px;
        }

        .btn-custom {
            font-size: 1.1rem;
            padding: 12px 28px;
            border-radius: 50px;
        }

        .btn-login {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        .btn-register {
            background-color: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-register:hover {
            background-color: #fff;
            color: #000;
        }

        footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: #bbb;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="hero">
    <h1>Temukan Petualanganmu</h1>
    <p>Sewa perlengkapan hiking premium di <strong>RDOutdoor</strong> dan jelajahi alam bebas tanpa batas.</p>

    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-custom btn-login">Masuk ke Dashboard</a>
    @else
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('login') }}" class="btn btn-custom btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn btn-custom btn-register">Daftar</a>
        </div>
    @endauth
</div>

<footer>
    &copy; {{ date('Y') }} RDOutdoor — Menyatu dengan Alam
</footer>

</body>
</html>
