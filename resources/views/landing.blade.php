{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDOUTDOOR - Hiking & Outdoor Activities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background: rgba(248,250,252,0.32); /* overlay lebih transparan, gambar lebih jelas */
            z-index: 0;
        }
        main, .container, nav, .aboutus-bg, .row, .col-lg-6, .col-md-6, .col-md-4, .col-md-8 {
            position: relative;
            z-index: 1;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: #11443e;
            line-height: 1.1;
            margin-top: 2.5rem;
            text-shadow:
                0 2px 8px rgba(0,0,0,0.08),
                0 0 6px #fff,
                0 2px 6px #fff,
                2px 0 6px #fff,
                -2px 0 6px #fff,
                0 -2px 6px #fff;
        }
        .hero-sub {
            color: #fff;
            font-weight: 600;
            text-shadow:
                0 2px 8px rgba(23,99,92,0.13),
                0 0 6px #11443e,
                0 2px 6px #11443e,
                2px 0 6px #11443e,
                -2px 0 6px #11443e,
                0 -2px 6px #11443e;
        }
        .rounded-hero-img { border-radius: 2.5rem; box-shadow: 0 8px 32px rgba(23,99,92,0.08); transition: box-shadow .3s, transform .3s; cursor:pointer; }
        .rounded-hero-img:hover, .rounded-hero-img:focus { box-shadow: 0 16px 48px rgba(23,99,92,0.18); transform: scale(1.06) rotate(-2deg); }
        .nav-link, .btn { border-radius: 2rem; transition: background .2s, color .2s, box-shadow .2s, transform .2s; }
        .nav-link:hover, .nav-link:focus { background: #e6f4f1; color: #17635c !important; box-shadow: 0 2px 8px rgba(23,99,92,0.08); transform: translateY(-2px) scale(1.04); }
        .btn-outline-primary:hover, .btn-outline-primary:focus { background: #17635c; color: #fff !important; border-color: #17635c; box-shadow: 0 4px 16px rgba(23,99,92,0.12); transform: scale(1.07); }
        .btn-primary { transition: background .2s, color .2s, box-shadow .2s, transform .2s; }
        .btn-primary:hover, .btn-primary:focus { background: #1b7c6e; color: #fff; box-shadow: 0 4px 16px rgba(23,99,92,0.12); transform: scale(1.07); }
        .form-control { transition: box-shadow .2s, border-color .2s, transform .2s; }
        .form-control:focus, .form-control:hover { border-color: #17635c; box-shadow: 0 0 0 0.2rem rgba(23,99,92,.12); transform: scale(1.03); }
        .feature-badge { background: #e6f4f1; color: #17635c; font-weight: 600; border-radius: 1rem; padding: 0.25rem 1rem; transition: background .2s, color .2s, box-shadow .2s, transform .2s; cursor:pointer; }
        .feature-badge:hover, .feature-badge:focus { background: #17635c; color: #fff; box-shadow: 0 2px 8px rgba(23,99,92,0.08); transform: scale(1.08); }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link { background: #17635c; color: #fff; }
        .about-center { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .btn-light { transition: box-shadow .2s, transform .2s; }
        .btn-light:hover, .btn-light:focus { box-shadow: 0 2px 8px rgba(23,99,92,0.10); transform: scale(1.08); }
        /* Tombol Mulai Rental versi lebih gelap */
        .btn-mulai-rental {
            display: inline-block;
            background: linear-gradient(90deg, #17635c 60%, #145244 100%);
            color: #fff !important;
            font-weight: 700;
            font-size: 1.15rem;
            padding: 0.75rem 2.2rem;
            border-radius: 2rem;
            box-shadow: 0 4px 16px rgba(23,99,92,0.13);
            border: none;
            transition: background .2s, color .2s, box-shadow .2s, transform .2s;
            letter-spacing: 1px;
        }
        .btn-mulai-rental:hover, .btn-mulai-rental:focus {
            background: linear-gradient(90deg, #145244 60%, #17635c 100%);
            color: #fff !important;
            box-shadow: 0 8px 32px rgba(23,99,92,0.18);
            transform: scale(1.07);
        }
        .navbar-brand-logo {
            display: flex; align-items: center; gap: 0.7rem;
            font-weight: bold; font-size: 1.3rem; letter-spacing: 2px; color: #17635c;
            text-decoration: none;
        }
        .navbar-brand-logo img {
            width: 38px; height: 38px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(23,99,92,0.10);
        }
        /* ABOUT US SECTION STYLES */
        .aboutus-bg {
            position: relative;
            padding-top: 3rem;
            padding-bottom: 3rem;
            background: linear-gradient(120deg, #e6f4f1 60%, #ffe3db 100%);
            border-radius: 2.5rem;
            margin-bottom: 3rem;
            overflow: hidden;
        }
        .aboutus-bg::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(248,250,252,0.82); /* overlay lebih pudar untuk about us */
            z-index: 0;
            border-radius: 2.5rem;
        }
        .aboutus-bg > .container, .aboutus-bg .row, .aboutus-bg .col-md-6 {
            position: relative;
            z-index: 1;
        }
        .aboutus-title {
            font-size:2.5rem;
            color:#17635c;
            letter-spacing:1px;
            font-weight:bold;
            text-shadow:
                0 0 6px #fff,
                0 2px 6px #fff,
                2px 0 6px #fff,
                -2px 0 6px #fff,
                0 -2px 6px #fff;
        }
        .aboutus-desc {
            font-size:1.1rem;
            color:#fff;
            max-width:420px;
            text-shadow:
                0 0 6px #11443e,
                0 2px 6px #11443e,
                2px 0 6px #11443e,
                -2px 0 6px #11443e,
                0 -2px 6px #11443e;
            /* Lembut, tidak kaku */
        }
        .aboutus-bg p {
            font-size: 1.1rem;
            color: #333;
            max-width: 420px;
        }
        .aboutus-bg .btn-mulai-rental {
            font-size: 1rem;
            padding: 0.7rem 2rem;
        }
        .aboutus-bg svg {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }
        .aboutus-bg img {
            position: relative;
            z-index: 2;
            max-width: 480px;
            width: 95%;
            min-width: 220px;
            border-radius: 2rem;
            box-shadow: 0 8px 32px rgba(23,99,92,0.10);
            object-fit: cover;
            margin-top: 40px;
        }
        /* Animasi transisi untuk About Us */
        .aboutus-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1.4s cubic-bezier(.33,1.2,.5,1), transform 1.4s cubic-bezier(.33,1.2,.5,1);
        }
        .aboutus-animate.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Stroke putih lebih tipis untuk tulisan hijau */
        .stroke-green {
            color: #17635c;
            text-shadow:
                0 1px 2px #fff,
                0 0.5px 1px #fff;
        }
        .stroke-green-light {
            color: #11443e;
            text-shadow:
                0 1px 2px #fff;
        }
        /* CONTACT US SECTION STYLES */
        .contactus-title {
            font-size:2.5rem;
            color:#17635c;
            letter-spacing:1px;
            font-weight:bold;
            text-shadow:
                0 0 6px #fff,
                0 2px 6px #fff,
                2px 0 6px #fff,
                -2px 0 6px #fff,
                0 -2px 6px #fff;
        }
        .contactus-desc {
            font-size:1.1rem;
            color:#fff;
            max-width:420px;
            text-shadow:
                0 0 6px #11443e,
                0 2px 6px #11443e,
                2px 0 6px #11443e,
                -2px 0 6px #11443e,
                0 -2px 6px #11443e;
        }
        .contactus-stroke {
            text-shadow:
                0 0 6px #fff,
                0 2px 6px #fff,
                2px 0 6px #fff,
                -2px 0 6px #fff,
                0 -2px 6px #fff;
        }
        .contactus-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1.2s cubic-bezier(.33,1.2,.5,1), transform 1.2s cubic-bezier(.33,1.2,.5,1);
        }
        .contactus-animate.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Animasi fade out untuk body */
        .fadeout-transition {
            animation: fadeOutBody 0.55s cubic-bezier(.4,0,.2,1) forwards;
        }
        @keyframes fadeOutBody {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        /* Fade out About Us saat scroll ke Contact Us */
        .aboutus-fadeout {
            opacity: 0.15;
            transition: opacity 0.7s cubic-bezier(.33,1.2,.5,1);
            pointer-events: none;
        }
        .aboutus-desc-fadeout {
            opacity: 0;
            transition: opacity 0.7s cubic-bezier(.33,1.2,.5,1);
        }
        .aboutus-desc-visible {
            opacity: 1;
            transition: opacity 0.7s cubic-bezier(.33,1.2,.5,1);
        }
        .stroke-white-green {
            color: #fff;
            text-shadow:
                0 0 4px #17635c,
                0 2px 4px #17635c,
                2px 0 4px #17635c,
                -2px 0 4px #17635c,
                0 -2px 4px #17635c;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-4">
        <div class="container">
            <a href="/" class="navbar-brand-logo">
                <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOUTDOOR">
                <span>RDOUTDOOR</span>
            </a>
            <form class="d-none d-lg-flex ms-4 flex-grow-1" action="{{ route('search') }}" method="GET">
                <input class="form-control rounded-pill px-4" type="search" name="q" placeholder="Cari alat outdoor..." style="max-width:320px;">
                <button class="btn btn-light ms-2 rounded-circle" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <ul class="navbar-nav ms-auto align-items-center gap-2 nav-pills">
                <li class="nav-item"><a class="nav-link" href="#start-rental-btn">Rental</a></li>
                <li class="nav-item"><a class="nav-link" href="#aboutus">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#contactus">Contact</a></li>
                <li class="nav-item"><a class="btn btn-outline-success px-4" style="border-color:#17635c;color:#17635c;" onmouseover="this.style.background='#17635c';this.style.color='#fff';" onmouseout="this.style.background='transparent';this.style.color='#17635c';" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="btn btn-success px-4" style="background:#17635c;border-color:#17635c;" onmouseover="this.style.background='#1b7c6e';" onmouseout="this.style.background='#17635c';" href="{{ route('register') }}">Daftar</a></li>
            </ul>
        </div>
    </nav>
    <div class="container" style="padding-top:2rem;padding-bottom:3rem;">
        <div class="row align-items-center g-5" style="margin-top:-2.5rem;">
            <div class="col-lg-6">
                <div class="mb-2 feature-badge"><i class="bi bi-tree"></i> Hiking & Outdoor Activities</div>
                <div class="hero-title mb-3">Your Adventure<br>Starts Here!</div>
                <div class="mb-4 hero-sub">Temukan alat outdoor terbaik, tips hiking, dan mulai petualanganmu bersama RDOUTDOOR.</div>
                @if(isset($reviewCount) && $reviewCount >= 10)
                <div class="d-flex align-items-center mb-4">
                    <span class="feature-badge">{{ $reviewCount }}+ Review Customer</span>
                </div>
                @endif
                <a href="{{ route('login') }}" id="start-rental-btn" class="btn-mulai-rental mb-3">Mulai Rental <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative" style="margin-top:-1.5rem;">
                    <img src="{{ asset('images/logorido.jpg') }}" class="img-fluid rounded-hero-img" alt="Logo RDOUTDOOR" style="background:#fff;max-width:400px;max-height:400px;padding:2rem;">
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US SECTION START -->
    <section id="aboutus" class="aboutus-animate" style="padding:0;margin-bottom:2rem;">
      <div style="background: url('{{ asset('images/20008380_6221846.jpg') }}') center/cover no-repeat; border-radius:2rem; overflow:hidden; position:relative; min-height:140px; margin-bottom:1.5rem;">
        <div style="background:rgba(23,99,92,0.48); min-height:140px; display:flex; align-items:center; justify-content:center;">
          <div style="width:100%;text-align:center;padding:1.2rem 0.5rem 1.2rem 0.5rem;">
            <span style="display:inline-flex; align-items:center; background:rgba(255,255,255,0.13); border-radius:2rem 1.2rem 2rem 1.2rem; padding:0.3rem 1.5rem; box-shadow:0 2px 12px rgba(23,99,92,0.10); gap:0.7rem;">
              <span class="stroke-white-green" style="font-size:2rem;font-weight:800;letter-spacing:1px;vertical-align:middle;">ABOUT US</span>
              <img src="{{ asset('images/logorido.jpg') }}" alt="Logo RDOUTDOOR" style="width:38px;height:38px;object-fit:cover;border-radius:50%;box-shadow:0 2px 8px #17635c;vertical-align:middle;align-self:center;">
            </span>
            <div style="margin-top:0.7rem;">
              <span class="stroke-white-green" style="font-size:1rem;letter-spacing:0.5px;">Platform Sewa Alat Hiking & Outdoor</span>
            </div>
          </div>
        </div>
      </div>
      <div class="container" style="max-width:900px;">
        <div class="row align-items-center g-3">
          <div class="col-lg-7 col-12 mb-2 mb-lg-0">
            <h2 class="stroke-white-green" style="font-size:1.5rem;font-weight:700;line-height:1.2;">Temukan Sensasi Petualangan Bersama RDOUTDOOR</h2>
            <p class="stroke-white-green" style="font-size:1rem;margin:0.7rem 0 0.5rem 0;max-width:480px;">Ridho Outdoor adalah platform digital untuk sewa alat hiking & camping. Kami membantu para pendaki, pecinta alam, dan penggiat outdoor mendapatkan perlengkapan terbaik tanpa harus membeli. Nikmati kemudahan, kualitas, dan pengalaman sewa yang menyatu dengan alam!</p>
          </div>
          <div class="col-lg-5 col-12">
            <div class="row g-2">
              <div class="col-6">
                <div class="bg-white shadow rounded-4 text-center py-2 px-1 mb-1">
                  <div class="stroke-white-green" style="font-size:1.2rem;font-weight:700;">200+</div>
                  <div class="stroke-white-green" style="font-size:0.9rem;">Order Sewa</div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-white shadow rounded-4 text-center py-2 px-1 mb-1">
                  <div class="stroke-white-green" style="font-size:1.2rem;font-weight:700;">98%</div>
                  <div class="stroke-white-green" style="font-size:0.9rem;">Kepuasan Customer</div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-white shadow rounded-4 text-center py-2 px-1 mb-1">
                  <div class="stroke-white-green" style="font-size:1.2rem;font-weight:700;">25+</div>
                  <div class="stroke-white-green" style="font-size:0.9rem;">Produk Outdoor</div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-white shadow rounded-4 text-center py-2 px-1 mb-1">
                  <div class="stroke-white-green" style="font-size:1.2rem;font-weight:700;">10K+</div>
                  <div class="stroke-white-green" style="font-size:0.9rem;">User & Komunitas</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12 col-lg-8">
            <div id="aboutus-desc-fade" class="stroke-white-green aboutus-desc-visible" style="font-size:1rem;line-height:1.5;">Kami percaya setiap orang berhak menjelajah keindahan alam dengan mudah dan aman. Misi kami adalah menyediakan layanan sewa alat outdoor yang mudah, terpercaya, dan berkualitas, agar petualanganmu selalu berkesan dan tak terlupakan.</div>
          </div>
        </div>
      </div>
    </section>
    <!-- ABOUT US SECTION END -->
    <!-- CONTACT US SECTION START -->
    <div class="py-5 contactus-animate" id="contactus">
        <div class="container" style="max-width:700px;">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="contactus-title mb-2">CONTACT US</h2>
                    <div style="width:70px;height:4px;background:#17635c;border-radius:2px;margin:0 auto 1.5rem auto;"></div>
                    <p class="mb-4 contactus-desc mx-auto" style="text-align:center;">
                        Hubungi kami untuk pertanyaan, kerjasama, atau bantuan seputar penyewaan alat outdoor.
                    </p>
                </div>
                <div class="col-12 text-center">
                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:2.7rem;height:2.7rem;background:#fff;border-radius:50%;box-shadow:0 2px 8px rgba(23,99,92,0.13);border:2px solid #25D366;overflow:hidden;">
                                <img src="{{ asset('images/whatsapp.jpg') }}" alt="WhatsApp" style="width:1.7rem;height:1.7rem;object-fit:contain;">
                            </span>
                            <span class="fw-semibold contactus-stroke" style="font-size:1.15rem;color:#11443e;">081211830261</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:2.7rem;height:2.7rem;background:#fff;border-radius:50%;box-shadow:0 2px 8px rgba(23,99,92,0.13);border:2px solid #E4405F;overflow:hidden;">
                                <img src="{{ asset('images/instagram.jpg') }}" alt="Instagram" style="width:1.7rem;height:1.7rem;object-fit:contain;">
                            </span>
                            <span class="fw-semibold contactus-stroke" style="font-size:1.15rem;color:#11443e;">@rdoutdoor11</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-size:1.5rem;color:#17635c;background:#fff;border-radius:50%;padding:4px 8px;box-shadow:0 2px 8px rgba(23,99,92,0.13);border:2px solid #17635c;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>
                            <span class="fw-semibold contactus-stroke" style="font-size:1.1rem;color:#11443e;">Serang Cibarusah</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTACT US SECTION END -->
    {{-- Section rental, about, contact, dan lainnya disembunyikan sesuai permintaan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rentalNavBtn = document.querySelector('a.nav-link[href="#start-rental-btn"]');
            const mulaiRentalBtn = document.getElementById('start-rental-btn');
            if (rentalNavBtn && mulaiRentalBtn) {
                rentalNavBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Buat popover/toast sederhana
                    let toast = document.createElement('div');
                    toast.innerText = 'Klik tombol Mulai Rental di bawah untuk memulai penyewaan.';
                    toast.style.position = 'absolute';
                    toast.style.left = '50%';
                    toast.style.transform = 'translateX(-50%)';
                    toast.style.top = (mulaiRentalBtn.getBoundingClientRect().top + window.scrollY - 60) + 'px';
                    toast.style.background = '#17635c';
                    toast.style.color = '#fff';
                    toast.style.padding = '12px 24px';
                    toast.style.borderRadius = '1.5rem';
                    toast.style.boxShadow = '0 4px 16px rgba(23,99,92,0.13)';
                    toast.style.fontWeight = 'bold';
                    toast.style.zIndex = 9999;
                    toast.style.fontSize = '1rem';
                    toast.style.transition = 'opacity .3s';
                    toast.style.opacity = 1;
                    document.body.appendChild(toast);
                    setTimeout(() => { toast.style.opacity = 0; }, 1800);
                    setTimeout(() => { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 2200);
                });
            }
        });
        // Animasi transisi About Us saat scroll atau klik About
        document.addEventListener('DOMContentLoaded', function() {
            const aboutSection = document.getElementById('aboutus');
            // Intersection Observer untuk animasi berulang saat scroll
            if (window.IntersectionObserver && aboutSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            aboutSection.classList.add('active');
                        } else {
                            aboutSection.classList.remove('active');
                        }
                    });
                }, { threshold: 0.3 });
                observer.observe(aboutSection);
            } else {
                // fallback: langsung tampil
                aboutSection.classList.add('active');
            }
            // Smooth scroll dan animasi saat klik About
            const aboutNavBtn = document.querySelector('a.nav-link[href="#aboutus"]');
            if (aboutNavBtn && aboutSection) {
                aboutNavBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    aboutSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Tidak perlu setTimeout class active, biarkan observer yang handle
                });
            }
        });
        // Animasi transisi Contact Us saat scroll
        document.addEventListener('DOMContentLoaded', function() {
            const contactSection = document.getElementById('contactus');
            if (window.IntersectionObserver && contactSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            contactSection.classList.add('active');
                        } else {
                            contactSection.classList.remove('active');
                        }
                    });
                }, { threshold: 0.3 });
                observer.observe(contactSection);
            } else {
                contactSection.classList.add('active');
            }
            // Smooth scroll dan animasi saat klik Contact
            const contactNavBtn = document.querySelector('a.nav-link[href="#contactus"]');
            if (contactNavBtn && contactSection) {
                contactNavBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Cek apakah contactSection sudah sepenuhnya terlihat
                    const rect = contactSection.getBoundingClientRect();
                    const fullyVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
                    if (!fullyVisible) {
                        contactSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                });
            }
        });
        // Animasi fade out dan redirect saat klik tombol Login/Daftar
        document.addEventListener('DOMContentLoaded', function() {
            const loginBtn = document.querySelector('a[href="{{ route('login') }}"]');
            const registerBtn = document.querySelector('a[href="{{ route('register') }}"]');
            const body = document.body;
            const html = document.documentElement;
            function handleFadeOutAndRedirect(url) {
                // Tambahkan class fadeout-transition ke body
                body.classList.add('fadeout-transition');
                // Tunggu hingga animasi selesai (550ms) sebelum redirect
                setTimeout(() => {
                    window.location.href = url;
                }, 550);
            }
            if (loginBtn) {
                loginBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleFadeOutAndRedirect('{{ route('login') }}');
                });
            }
            if (registerBtn) {
                registerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleFadeOutAndRedirect('{{ route('register') }}');
                });
            }
        });
    </script>
    <script>
    // Animasi transisi fade out saat klik Login/Daftar
    document.addEventListener('DOMContentLoaded', function() {
        function handleFadeOutAndRedirect(e, url) {
            e.preventDefault();
            document.body.classList.add('fadeout-transition');
            setTimeout(function() {
                window.location.href = url;
            }, 520); // waktu harus sesuai dengan durasi animasi CSS
        }
        // Tombol Login
        var loginBtn = document.querySelector('a.btn[href*="login"]');
        if (loginBtn) {
            loginBtn.addEventListener('click', function(e) {
                handleFadeOutAndRedirect(e, this.getAttribute('href'));
            });
        }
        // Tombol Daftar
        var daftarBtn = document.querySelector('a.btn[href*="register"]');
        if (daftarBtn) {
            daftarBtn.addEventListener('click', function(e) {
                handleFadeOutAndRedirect(e, this.getAttribute('href'));
            });
        }
        // Tombol Mulai Rental (jika diarahkan ke login)
        var mulaiRentalBtn = document.getElementById('start-rental-btn');
        if (mulaiRentalBtn && mulaiRentalBtn.getAttribute('href').includes('login')) {
            mulaiRentalBtn.addEventListener('click', function(e) {
                handleFadeOutAndRedirect(e, this.getAttribute('href'));
            });
        }
    });
    </script>
    <script>
    // Hapus fadeout-transition SECEPAT MUNGKIN di awal load dan saat kembali/back
    (function() {
      function removeFadeout() {
        document.body && document.body.classList.remove('fadeout-transition');
      }
      // Untuk back/forward cache (bfcache)
      window.addEventListener('pageshow', removeFadeout);
      // Untuk reload normal
      document.addEventListener('DOMContentLoaded', removeFadeout);
      // Untuk jaga-jaga, juga saat visibility berubah
      document.addEventListener('visibilitychange', function() {
        if (!document.hidden) removeFadeout();
      });
      // Eksekusi langsung jika body sudah ada
      if (document.body) removeFadeout();
    })();
    </script>
    <script>
        // Fade out About Us saat scroll ke Contact Us
        document.addEventListener('DOMContentLoaded', function() {
            const aboutSection = document.getElementById('aboutus');
            const contactSection = document.getElementById('contactus');
            if (aboutSection && contactSection && window.IntersectionObserver) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            aboutSection.classList.add('aboutus-fadeout');
                        } else {
                            aboutSection.classList.remove('aboutus-fadeout');
                        }
                    });
                }, { threshold: 0.15 });
                observer.observe(contactSection);
            }
        });
        // Fade out hanya keterangan About Us saat Contact Us muncul
        document.addEventListener('DOMContentLoaded', function() {
            const aboutDesc = document.getElementById('aboutus-desc-fade');
            const contactSection = document.getElementById('contactus');
            if (aboutDesc && contactSection && window.IntersectionObserver) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            aboutDesc.classList.remove('aboutus-desc-visible');
                            aboutDesc.classList.add('aboutus-desc-fadeout');
                        } else {
                            aboutDesc.classList.remove('aboutus-desc-fadeout');
                            aboutDesc.classList.add('aboutus-desc-visible');
                        }
                    });
                }, { threshold: 0.15 });
                observer.observe(contactSection);
            }
        });
    </script>
  </body>
</html>
