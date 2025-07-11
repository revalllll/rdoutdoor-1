<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .sidebar {
                min-height: 100vh;
                transition: margin-left 0.4s cubic-bezier(.4,2,.6,1), box-shadow 0.3s;
                z-index: 1040;
                margin-left: 0;
            }
            .sidebar.closed { margin-left: -220px; }
            .sidebar-content { transition: opacity 0.3s; opacity: 1; }
            .sidebar-content.hide { opacity: 0; }
            .sidebar-open-btn { display: none; position: absolute; top: 10px; left: 10px; z-index: 1100; font-size: 1.5rem; }
            .sidebar.closed .sidebar-open-btn { display: block !important; }
            .sidebar.closed .sidebar-content { display: none !important; }
            .sidebar-mobile {
                position: fixed; top: 0; left: -260px; width: 240px; height: 100vh;
                background: #212529; overflow-y: auto;
                transition: left 0.3s cubic-bezier(.4,2,.6,1), box-shadow 0.3s;
                box-shadow: 0 0 0 rgba(0,0,0,0); z-index: 2000;
            }
            .sidebar-mobile.show { left: 0; box-shadow: 0 0 20px rgba(0,0,0,0.2); }
            .sidebar-mobile .close-btn {
                position: absolute; top: 10px; right: 10px; color: #fff;
                font-size: 1.5rem; background: none; border: none;
            }
            @media (min-width: 992px) {
                .sidebar-mobile, .sidebar-mobile.show, .sidebar-mobile .close-btn { display: none !important; }
            }
            @media (max-width: 991.98px) {
                .sidebar { display: none !important; }
                .main-content { padding-left: 0 !important; }
            }
            .brand-logo {
                font-weight: bold;
                font-size: 1.3rem;
                letter-spacing: 2px;
                color: #fff;
            }
            .btn-green {
                background: linear-gradient(90deg, #17635c 60%, #1b7c6e 100%) !important;
                color: #fff !important;
                font-weight: 700;
                border-radius: 2rem;
                border: none;
                box-shadow: 0 4px 16px rgba(23,99,92,0.13);
                transition: background .2s, color .2s, box-shadow .2s, transform .2s;
            }
            .btn-green:hover, .btn-green:focus {
                background: linear-gradient(90deg, #1b7c6e 60%, #17635c 100%) !important;
                color: #fff !important;
                box-shadow: 0 8px 32px rgba(23,99,92,0.18);
                transform: scale(1.04);
            }
        </style>
        @yield('styles')
    </head>
    <body class="font-sans antialiased">
        @include('components.user-topbar')
        <!-- Error reporting -->
        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        <!-- Page Content -->
        <main>
            @yield('content')
            {{ $slot ?? '' }}
        </main>
        @stack('scripts')
    </body>
</html>
