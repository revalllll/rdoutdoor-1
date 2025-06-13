<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Kata Sandi - RDOutdoor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: url('{{ asset('images/20008380_6221846.jpg') }}') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      position: relative;
    }
    body::before {
      content: '';
      position: fixed;
      top: 0; left: 0; width: 100vw; height: 100vh;
      background: rgba(248,250,252,0.32);
      z-index: 0;
    }
    .bg-white {
      position: relative;
      z-index: 1;
    }
    .btn-green {
      background: linear-gradient(90deg, #17635c 60%, #1b7c6e 100%);
      color: #fff !important;
      font-weight: 700;
      border-radius: 1.5rem;
      transition: background .2s, color .2s, box-shadow .2s, transform .2s;
    }
    .btn-green:hover, .btn-green:focus {
      background: linear-gradient(90deg, #1b7c6e 60%, #17635c 100%);
      color: #fff !important;
      box-shadow: 0 8px 32px rgba(23,99,92,0.18);
      transform: scale(1.04);
    }
    .text-green-link { color: #17635c; transition: color .2s, text-decoration .2s; }
    .text-green-link:hover, .text-green-link:focus { color: #1b7c6e; text-decoration: underline; text-shadow: 0 2px 8px #b2cfc7; }
    .focus-green:focus { outline: 2.5px solid #17635c; outline-offset: 2px; box-shadow: 0 0 0 2px #b2cfc7; }
  </style>
</head>
<body class="flex items-center justify-center">

  <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md" style="margin: 48px auto; background: rgba(255,255,255,0.65); backdrop-filter: blur(4px); box-shadow: 0 8px 32px rgba(23,99,92,0.13);">
    <!-- Logo & Heading -->
    <div class="text-center mb-6">
      <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOutdoor" class="w-24 h-24 mx-auto mb-4 rounded-full">
      <h2 class="text-2xl font-semibold text-gray-800">Lupa Kata Sandi?</h2>
      <p class="text-sm text-gray-500">Masukkan email Anda untuk mereset kata sandi.</p>
    </div>

    <!-- Form Forgot Password -->
    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus-green" required placeholder="Masukkan Email">
      </div>

      <div class="mb-4">
        <button type="submit" class="w-full py-2 px-4 btn-green text-white font-semibold rounded-md focus-green">
          Kirim Tautan Reset Kata Sandi
        </button>
      </div>
    </form>

    <!-- Link ke Login -->
    <p class="mt-4 text-center text-sm text-gray-600">
      Ingat kata sandi?
      <a href="{{ route('login') }}" class="text-green-link font-medium">Masuk di sini</a>
    </p>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var emailInput = document.querySelector('input[name="email"]');
      if(emailInput) emailInput.focus();
    });
  </script>
</body>
</html>
