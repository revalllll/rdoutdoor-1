<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - RDOutdoor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(to right,rgb(78, 200, 129),rgb(78, 200, 129));
      min-height: 100vh;
    }
  </style>
</head>
<body class="flex items-center justify-center">

  <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
    <!-- Logo & Heading -->
    <div class="text-center mb-6">
      <!-- Logo -->
      <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOutdoor" class="w-24 h-24 mx-auto mb-4 rounded-full">
      <h2 class="text-2xl font-semibold text-gray-800">Selamat Datang di RDOUTDOOR</h2>
      <p class="text-sm text-gray-500">Silakan login untuk menyewa alat hiking favoritmu</p>
    </div>

    <!-- Login with Google Button -->
    <div class="mb-6">
      <a href="/auth/google" class="flex items-center justify-center w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition duration-200">
        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5 mr-2">
        Masuk dengan Google
      </a>
    </div>

    <!-- Divider -->
    <div class="flex items-center my-4">
      <div class="w-full border-t border-gray-300"></div>
      <span class="mx-2 text-sm text-gray-500">atau</span>
      <div class="w-full border-t border-gray-300"></div>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required autofocus placeholder="Masukkan Email">
      </div>

      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
        <input type="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Masukkan Kata Sandi">
      </div>

      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
          <input type="checkbox" name="remember" id="remember" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500 rounded">
          <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
        </div>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Lupa kata sandi?</a>
        @endif
      </div>

      <div class="mb-4">
        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
          Masuk
        </button>
      </div>
    </form>

    <!-- Link ke Register -->
    <p class="text-center text-sm text-gray-600">
      Belum punya akun? 
      <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Daftar di sini</a>
    </p>
  </div>

</body>
</html>
