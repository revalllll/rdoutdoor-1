<!-- Sidebar Desktop User -->
<div class="sidebar-content" id="sidebarContentUser">
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <span class="brand-logo">RDOUTDOOR</span>
        <button class="btn btn-sm btn-dark d-none d-lg-inline ms-2" id="sidebarCloseBtnUser" style="font-size:1.5rem;">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>
    <hr class="text-white w-100">
    <ul class="nav nav-pills flex-column mb-auto w-100">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('cart.index') }}" class="nav-link text-white {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                <i class="bi bi-cart"></i> Keranjang
            </a>
        </li>
        <li>
            <a href="{{ route('orders.index') }}" class="nav-link text-white {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <i class="bi bi-bag"></i> Pesanan Saya
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="nav-link text-white {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Profile
            </a>
        </li>
        <li>
            <a href="{{ route('help') }}" class="nav-link text-white {{ request()->routeIs('help') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i> Bantuan/Kontak
            </a>
        </li>
    </ul>
    <hr class="text-white w-100">
    <form action="{{ route('logout') }}" method="POST" class="w-100">
        @csrf
        <button class="btn btn-outline-light w-100">Logout</button>
    </form>
</div>
<!-- Tombol open sidebar desktop -->
<button class="sidebar-open-btn btn btn-dark position-absolute" id="sidebarOpenBtnUser" style="top: 20px; left: 220px; display: none; z-index: 1200;">
    <i class="bi bi-chevron-right"></i>
</button>
<link rel="stylesheet" href="/css/sidebar-fix.css">
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar desktop slide left/right
    const sidebarDesktopUser = document.getElementById('sidebarDesktopUser');
    const sidebarContentUser = document.getElementById('sidebarContentUser');
    const sidebarCloseBtnUser = document.getElementById('sidebarCloseBtnUser');
    const sidebarOpenBtnUser = document.getElementById('sidebarOpenBtnUser');
    if (sidebarDesktopUser && sidebarContentUser && sidebarCloseBtnUser && sidebarOpenBtnUser) {
        sidebarCloseBtnUser.addEventListener('click', function() {
            sidebarDesktopUser.classList.add('closed');
            sidebarOpenBtnUser.style.display = 'block';
        });
        sidebarOpenBtnUser.addEventListener('click', function() {
            sidebarDesktopUser.classList.remove('closed');
            sidebarOpenBtnUser.style.display = 'none';
        });
        if (!sidebarDesktopUser.classList.contains('closed')) {
            sidebarOpenBtnUser.style.display = 'none';
        }
    }
    // Sidebar mobile
    const sidebarMobileUser = document.getElementById('sidebarMobileUser');
    const closeSidebarUser = document.getElementById('closeSidebarUser');
    if (sidebarMobileUser && closeSidebarUser) {
        closeSidebarUser.addEventListener('click', function() {
            sidebarMobileUser.classList.remove('show');
        });
    }
});
</script>
<style>
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
</style>
