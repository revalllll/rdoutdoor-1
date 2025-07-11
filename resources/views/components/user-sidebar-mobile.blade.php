<button class="close-btn" id="closeSidebarUser" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
<div class="d-flex flex-column align-items-start px-3 pt-4">
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="brand-logo">RDOUTDOOR</span>
    </a>
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
    <form action="{{ route('logout') }}" method="POST" class="w-100 mb-3">
        @csrf
        <button class="btn btn-outline-light w-100">Logout</button>
    </form>
</div>
