<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-2 animate__animated user-topbar-animate" style="z-index:9999;">
    <div class="container" style="min-height:70px;">
        <a href="/" class="navbar-brand-logo d-flex align-items-center gap-2 me-3">
            <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOUTDOOR" style="height:40px;width:40px;border-radius:8px;object-fit:cover;">
            <span class="fw-bold d-none d-sm-inline" style="color:#17635c;letter-spacing:2px;font-size:1.3rem;overflow:visible;white-space:nowrap;">RDOUTDOOR</span>
        </a>
        <form class="d-flex flex-grow-1 my-2 my-lg-0" action="{{ route('search') }}" method="GET" style="max-width:400px;">
            <input class="form-control rounded-pill px-4 search-landing-anim" type="search" name="q" placeholder="Cari alat outdoor..." style="max-width:100%;">
            <button class="btn btn-light ms-2 rounded-circle search-landing-anim" type="submit" style="width:42px;height:42px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-search"></i></button>
        </form>
        <ul class="navbar-nav ms-auto align-items-center gap-2 nav-pills user-topbar-menu-fix mt-3 mt-lg-0" style="display:flex;flex-direction:row;align-items:center;gap:1.2rem;background:none;position:static;z-index:10;visibility:visible;opacity:1;">
            <li class="nav-item"><a class="nav-link nav-landing-anim fw-semibold d-flex align-items-center" href="/">Home</a></li>
            <li class="nav-item"><a class="nav-link nav-landing-anim fw-semibold d-flex align-items-center" href="{{ url('/dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link nav-landing-anim fw-semibold d-flex align-items-center" style="white-space:nowrap;" href="{{ route('cart.index') }}"><i class="bi bi-cart me-1"></i>Keranjang Saya</a></li>
            <li class="nav-item"><a class="nav-link nav-landing-anim fw-semibold d-flex align-items-center" style="white-space:nowrap;" href="{{ route('orders.index') }}">Pesanan Saya</a></li>
            <li class="nav-item"><a class="nav-link nav-landing-anim fw-semibold d-flex align-items-center" href="{{ url('/#contactus') }}">Contact</a></li>
        </ul>
        <div class="ms-lg-3 mt-3 mt-lg-0">
            @php
                $user = Auth::user();
                $userName = $user && isset($user->name) ? $user->name : 'Guest';
                $profilePhoto = $user && isset($user->profile_photo) && $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=17635c&color=fff&size=64';
                $wordCount = str_word_count($userName);
            @endphp
            <a href="{{ route('profile.edit') }}"
               class="btn btn-white border rounded-pill px-3 fw-semibold d-flex items-center animate__animated animate__fadeInDown topbar-profile-anim"
               style="max-width:170px;min-width:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;gap:0.35rem;align-items:center;justify-content:flex-end;transition:box-shadow .22s,transform .22s,background .22s,color .22s;box-shadow:0 2px 8px #17635c22;">
                <span class="d-flex align-items-center" style="gap:0.35rem;width:100%;min-width:0;">
                    @if($wordCount < 3)
                        <span class="me-1" style="display:inline-block;vertical-align:middle;font-weight:600;max-width:90px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#17635c;" title="{{ $userName }}">{{ $userName }}</span>
                    @else
                        <span class="me-1 text-truncate" style="max-width:70px;display:inline-block;vertical-align:middle;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;color:#17635c;" title="{{ $userName }}">{{ $userName }}</span>
                    @endif
                    <img src="{{ $profilePhoto }}" alt="Avatar" style="width:32px;height:32px;object-fit:cover;border-radius:50%;border:2px solid #e6f4f1;box-shadow:0 2px 8px #17635c22;flex-shrink:0;">
                </span>
            </a>
        </div>
    </div>
</nav>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
.user-topbar-animate { box-shadow: 0 2px 8px rgba(23,99,92,0.04) !important; }
.user-topbar-menu-fix {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 1.1rem !important;
    background: none !important;
    position: static !important;
    z-index: 10 !important;
    visibility: visible !important;
    opacity: 1 !important;
}
.navbar-brand-logo span { 
    max-width: none;
    overflow: visible; 
    text-overflow: unset; 
    white-space: nowrap; 
}
.nav-landing-anim {
    border-radius: 2rem;
    transition: background .2s, color .2s, box-shadow .2s, transform .2s;
    color: #444 !important;
    font-weight: 500;
    padding: 0.3rem 1rem;
}
.nav-landing-anim:hover, .nav-landing-anim:focus {
    background: #e6f4f1;
    color: #17635c !important;
    box-shadow: 0 2px 8px rgba(23,99,92,0.08);
    transform: translateY(-2px) scale(1.04);
}
.search-landing-anim {
    transition: box-shadow .2s, border-color .2s, transform .2s;
}
.search-landing-anim:focus, .search-landing-anim:hover {
    border-color: #17635c;
    box-shadow: 0 0 0 0.2rem rgba(23,99,92,.12);
    transform: scale(1.03);
}
@media (max-width: 991.98px) {
    .container { padding-left: 1rem !important; padding-right: 1rem !important; width: 100% !important; min-width: 0 !important; }
    .navbar-nav.user-topbar-menu-fix { gap: 1rem !important; }
    .navbar-collapse { background: #fff; box-shadow: 0 2px 8px rgba(23,99,92,0.04); border-radius: 1rem; margin-top: 0.5rem; }
    .navbar-nav.user-topbar-menu-fix { flex-direction: column !important; align-items: flex-start !important; width: 100%; }
    .navbar-nav.user-topbar-menu-fix .nav-item { width: 100%; }
    .navbar-nav.user-topbar-menu-fix .nav-link { width: 100%; text-align: left; }
    .topbar-profile-anim { width: 100%; justify-content: flex-start !important; }
    form.d-lg-flex { max-width: 220px !important; min-width: 0 !important; }
}
@media (max-width: 600px) {
    .nav-landing-anim[style*='max-width'] { max-width: 90px !important; }
    .nav-landing-anim .text-truncate { max-width: 38px !important; }
    .navbar-brand-logo span { font-size: 0.95rem !important; max-width: 60px !important; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .navbar-brand-logo img { height: 28px !important; width: 28px !important; }
    form.d-lg-flex { max-width: 120px !important; min-width: 0 !important; }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var topbar = document.querySelector('.user-topbar-animate');
        if (topbar) {
            topbar.classList.remove('animate__fadeInDown');
            setTimeout(function() {
                topbar.classList.add('animate__fadeInDown');
            }, 30);
        }
    });
</script>
