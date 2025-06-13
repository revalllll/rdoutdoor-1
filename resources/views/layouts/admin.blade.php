<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard') | RDOUTDOOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
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
        .table thead th { vertical-align: middle; }
        .table td, .table th { vertical-align: middle; }
        .btn { transition: transform 0.2s; }
        .btn:hover { transform: scale(1.05); }
        .hamburger {
            display: none; position: fixed; top: 18px; left: 18px; z-index: 2050;
            background: #212529; color: #fff; border: none; border-radius: 6px;
            padding: 8px 12px; font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        @media (max-width: 991.98px) { .hamburger { display: block; } }
        @media (min-width: 992px) {
            .hamburger { display: none !important; }
            .sidebar.closed ~ .hamburger { display: block !important; }
        }
        .brand-logo {
            font-weight: bold;
            font-size: 1.3rem;
            letter-spacing: 2px;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Hamburger Button (Mobile & Desktop) -->
    <button class="hamburger d-lg-none" id="hamburgerBtn" aria-label="Menu">
        <i class="bi bi-list"></i>
    </button>
    <button class="hamburger d-none d-lg-block" id="hamburgerDesktopBtn" aria-label="Menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar Desktop -->
            <nav class="col-12 col-lg-2 bg-dark sidebar py-3 d-none d-lg-block position-relative" id="sidebarDesktop">
                <button class="sidebar-open-btn btn btn-dark position-absolute" id="sidebarOpenBtn" style="top: 20px; left: 220px; display: none; z-index: 1200;">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <div class="sidebar-content" id="sidebarContent">
                    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
                        <span class="brand-logo">RDOUTDOOR</span>
                        <button class="btn btn-sm btn-dark d-none d-lg-inline ms-2" id="sidebarCloseBtn" style="font-size:1.5rem;">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                    </div>
                    <hr class="text-white w-100">
                    <ul class="nav nav-pills flex-column mb-auto w-100">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="bi bi-box-seam"></i> Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="bi bi-bag"></i> Order
                            </a>
                        </li>
                        {{-- Tambahkan menu lain jika perlu --}}
                    </ul>
                    <hr class="text-white w-100">
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button class="btn btn-outline-light w-100">Logout</button>
                    </form>
                </div>
            </nav>
            <!-- Sidebar Mobile -->
            <nav class="sidebar-mobile d-lg-none" id="sidebarMobile">
                <button class="close-btn" id="closeSidebar" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
                <div class="d-flex flex-column align-items-start px-3 pt-4">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
                        <span class="brand-logo">RDOUTDOOR</span>
                    </a>
                    <hr class="text-white w-100">
                    <ul class="nav nav-pills flex-column mb-auto w-100">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="bi bi-box-seam"></i> Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="bi bi-bag"></i> Order
                            </a>
                        </li>
                    </ul>
                    <hr class="text-white w-100">
                    <form action="{{ route('logout') }}" method="POST" class="w-100 mb-3">
                        @csrf
                        <button class="btn btn-outline-light w-100">Logout</button>
                    </form>
                </div>
            </nav>
            <main class="col main-content px-0 py-3">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
    AOS.init();

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar desktop slide left/right
        const sidebarDesktop = document.getElementById('sidebarDesktop');
        const sidebarContent = document.getElementById('sidebarContent');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
        const hamburgerDesktopBtn = document.getElementById('hamburgerDesktopBtn');
        const sidebarOpenBtn = document.getElementById('sidebarOpenBtn');

        if (sidebarDesktop && sidebarContent && sidebarCloseBtn && hamburgerDesktopBtn && sidebarOpenBtn) {
            sidebarCloseBtn.addEventListener('click', function() {
                sidebarDesktop.classList.add('closed');
                sidebarOpenBtn.style.display = 'block';
            });
            sidebarOpenBtn.addEventListener('click', function() {
                sidebarDesktop.classList.remove('closed');
                sidebarOpenBtn.style.display = 'none';
            });
            // Sembunyikan tombol open saat sidebar terbuka
            if (!sidebarDesktop.classList.contains('closed')) {
                sidebarOpenBtn.style.display = 'none';
            }
        }

        // Sidebar mobile
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebarMobile = document.getElementById('sidebarMobile');
        const closeSidebar = document.getElementById('closeSidebar');

        if (hamburgerBtn && sidebarMobile && closeSidebar) {
            hamburgerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebarMobile.classList.add('show');
                hamburgerBtn.classList.add('d-none');
            });

            closeSidebar.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebarMobile.classList.remove('show');
                hamburgerBtn.classList.remove('d-none');
            });

            document.addEventListener('click', function(e) {
                if (
                    sidebarMobile.classList.contains('show') &&
                    !sidebarMobile.contains(e.target) &&
                    e.target !== hamburgerBtn
                ) {
                    sidebarMobile.classList.remove('show');
                    hamburgerBtn.classList.remove('d-none');
                }
            });

            sidebarMobile.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
    </script>
</body>
</html>