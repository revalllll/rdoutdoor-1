<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Kata Sandi - RDOutdoor</title>
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
      <!-- Menambahkan Logo -->
      <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOutdoor" class="w-24 h-24 mx-auto mb-4 rounded-full">
      <h2 class="text-2xl font-semibold text-gray-800">Lupa Kata Sandi?</h2>
      <p class="text-sm text-gray-500">Masukkan email Anda untuk mereset kata sandi.</p>
    </div>

    <!-- Form Forgot Password -->
    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Masukkan Email">
      </div>

      <div class="mb-4">
        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md">
          Kirim Tautan Reset Kata Sandi
        </button>
      </div>
    </form>

    <!-- Link ke Login -->
    <p class="mt-4 text-center text-sm text-gray-600">
      Ingat kata sandi?
      <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Masuk di sini</a>
    </p>
  </div>

</body>
</html>
