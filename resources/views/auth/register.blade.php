<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - RDOutdoor</title>
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
    .login-animate {
      opacity: 0;
      transform: translateY(32px) scale(0.98);
      transition: opacity 0.7s cubic-bezier(.33,1.2,.5,1), transform 0.7s cubic-bezier(.33,1.2,.5,1);
    }
    .login-animate.active {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
    .login-animate.fadeout {
      opacity: 0;
      transform: translateY(32px) scale(0.98);
      transition: opacity 0.45s cubic-bezier(.33,1.2,.5,1), transform 0.45s cubic-bezier(.33,1.2,.5,1);
    }
    .loader-overlay {
      position: fixed;
      z-index: 9999;
      top: 0; left: 0; width: 100vw; height: 100vh;
      background: rgba(255,255,255,0.7);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity .3s;
      opacity: 0;
      pointer-events: none;
    }
    .loader-overlay.active {
      opacity: 1;
      pointer-events: all;
    }
    .hiking-svg { width: 180px; height: 120px; }
    .stickman {
      animation: walk-stickman 1.2s steps(6) infinite;
      transform-origin: bottom center;
    }
    @keyframes walk-stickman {
      0% { transform: translateX(0) scaleX(1); }
      20% { transform: translateX(12px) scaleX(1.02) rotate(-2deg); }
      40% { transform: translateX(24px) scaleX(0.98) rotate(2deg); }
      60% { transform: translateX(36px) scaleX(1.01) rotate(-1deg); }
      80% { transform: translateX(48px) scaleX(1.03) rotate(1deg); }
      100% { transform: translateX(60px) scaleX(1); }
    }
    .mountain {
      animation: mountain-fade 2s ease-in-out infinite alternate;
    }
    @keyframes mountain-fade {
      0% { opacity: 0.85; }
      100% { opacity: 1; }
    }
  </style>
</head>
<body class="flex items-center justify-center">
  <div class="loader-overlay" id="loaderHiking" aria-label="Sedang hiking ke server, mohon tunggu" tabindex="-1">
    <svg class="hiking-svg" viewBox="0 0 180 120" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
      <!-- Gunung -->
      <polygon class="mountain" points="40,110 90,30 140,110" fill="#17635c" stroke="#11443e" stroke-width="3"/>
      <polygon class="mountain" points="70,110 110,60 150,110" fill="#1b7c6e" stroke="#11443e" stroke-width="2" opacity=".7"/>
      <!-- Stickman -->
      <g class="stickman">
        <circle cx="30" cy="80" r="8" fill="#222"/>
        <rect x="28" y="88" width="4" height="18" rx="2" fill="#222"/>
        <rect x="24" y="98" width="4" height="16" rx="2" fill="#222" transform="rotate(-20 24 98)"/>
        <rect x="34" y="98" width="4" height="16" rx="2" fill="#222" transform="rotate(20 34 98)"/>
        <rect x="28" y="100" width="4" height="12" rx="2" fill="#222" transform="rotate(-10 28 100)"/>
        <rect x="28" y="100" width="4" height="12" rx="2" fill="#222" transform="rotate(10 32 100)"/>
        <!-- Tongkat -->
        <rect x="36" y="100" width="2" height="22" rx="1" fill="#8d674a" transform="rotate(15 36 100)"/>
      </g>
      <!-- Tanah -->
      <ellipse cx="90" cy="115" rx="70" ry="7" fill="#b2cfc7"/>
    </svg>
    <div style="font-weight:bold;color:#17635c;font-size:1.1rem;margin-top:1.5rem;text-align:center;">Sedang hiking ke server...<br>Mohon tunggu</div>
    <noscript><div style="color:#17635c;font-weight:bold;">Loading...</div></noscript>
  </div>
  <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md login-animate" style="margin: 48px auto; background: rgba(255,255,255,0.65); backdrop-filter: blur(4px); box-shadow: 0 8px 32px rgba(23,99,92,0.13);">
    <!-- Logo & Heading -->
    <div class="text-center mb-6">
      <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOutdoor" class="w-24 h-24 mx-auto mb-4 rounded-full">
      <h2 class="text-2xl font-semibold text-gray-800">Daftar di RDOutdoor</h2>
      <p class="text-sm text-gray-500">Bergabung dan nikmati pengalaman penyewaan alat hiking terbaik!</p>
    </div>
    <!-- Pesan Error -->
    @if ($errors->any())
      <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative z-10" role="alert" aria-live="polite">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <!-- Form Register -->
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus-green" required autofocus placeholder="Masukkan Nama Lengkap">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus-green" required placeholder="Masukkan Email">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
        <div class="relative">
          <input type="password" name="password" id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus-green pr-10" required placeholder="Masukkan Kata Sandi">
          <button type="button" id="togglePassword" tabindex="-1" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:transparent;border:none;padding:0;outline:none;" aria-label="Lihat sandi">
            <span id="eyeIcon"><i class="bi bi-eye"></i></span>
          </button>
        </div>
      </div>
      <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
        <input type="password" name="password_confirmation" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus-green" required placeholder="Konfirmasi Kata Sandi">
      </div>
      <div class="mb-4">
        <button type="submit" class="w-full py-2 px-4 btn-green text-white font-semibold rounded-md focus-green">
          Daftar
        </button>
      </div>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="text-green-link font-medium">Masuk di sini</a>
    </p>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Autofocus ke input nama
      var nameInput = document.querySelector('input[name="name"]');
      if(nameInput) nameInput.focus();
    });
    // Animasi masuk form daftar
    document.addEventListener('DOMContentLoaded', function() {
      var loginBox = document.querySelector('.login-animate');
      if (loginBox) {
        setTimeout(function() { loginBox.classList.add('active'); }, 80);
      }
      // Fade out saat submit
      var registerForm = document.querySelector('form[action*="register"]');
      if (registerForm && loginBox) {
        registerForm.addEventListener('submit', function(e) {
          loginBox.classList.remove('active');
          loginBox.classList.add('fadeout');
        });
      }
      // Toggle password
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
          const type = passwordInput.type === 'password' ? 'text' : 'password';
          passwordInput.type = type;
          eyeIcon.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });
      }
      // Loader hiking saat submit register
      var registerForm = document.querySelector('form[action*="register"]');
      var loader = document.getElementById('loaderHiking');
      if (registerForm && loader) {
        registerForm.addEventListener('submit', function() {
          loader.classList.add('active');
        });
      }
      // Hide loader if error message appears (for SPA or after reload)
      var errorBox = document.querySelector('.bg-red-100');
      if (errorBox && loader) {
        loader.classList.remove('active');
      }
    });
    // Tambahkan aria-label pada tombol show/hide password
    document.addEventListener('DOMContentLoaded', function() {
      var togglePassword = document.getElementById('togglePassword');
      if (togglePassword) togglePassword.setAttribute('aria-label', 'Tampilkan atau sembunyikan sandi');
    });
  </script>
</body>
</html>
