{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    @parent
    <style>
        body {
            background: #F5F5F5;
            font-family: 'Inter', 'Poppins', Arial, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            transition: margin-left 0.4s cubic-bezier(.4,2,.6,1), box-shadow 0.3s;
            z-index: 1040;
            margin-left: 0;
        }
        .sidebar.closed {
            margin-left: -220px !important;
        }
        .sidebar-content { transition: opacity 0.3s; opacity: 1; }
        .sidebar.closed .sidebar-content { opacity: 0; pointer-events: none; }
        .sidebar-open-btn { display: none; position: absolute; top: 20px; left: 220px; z-index: 1200; font-size: 1.5rem; }
        .sidebar.closed .sidebar-open-btn { display: block !important; }
        @media (max-width: 991.98px) {
            .sidebar { display: none !important; }
            .main-content { padding-left: 0 !important; }
        }

        .dashboard-card {
            box-shadow: 0 4px 24px rgba(0,104,74,0.07);
            border-radius: 1.2rem;
            border: none;
        }
        .dashboard-card .icon {
            width:48px;height:48px;
            display:flex;align-items:center;justify-content:center;
            border-radius:50%;
            font-size:2rem;
        }
        .dashboard-banner {
            width: 100%;
            min-height: 240px;
            background: url('/images/mesmerizing-scenery-green-mountains-with-cloudy-sky-surface.jpg') center/cover no-repeat;
            border-radius: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2.5rem 2.2rem 2.5rem 2.7rem;
            position: relative;
            box-shadow: 0 8px 32px rgba(0,104,74,0.10);
            margin-bottom: 2.5rem;
            overflow: visible; /* Perbaikan: agar dropdown tidak terpotong */
        }
        .dashboard-banner-content {
            color: #fff;
            z-index: 2;
            max-width: 520px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }
        .dashboard-banner-title {
            font-size: 2.3rem;
            font-weight: 800;
            margin-bottom: 0.7rem;
            line-height: 1.1;
        }
        .dashboard-banner-desc {
            font-size: 1.08rem;
            margin-bottom: 1.3rem;
            color: #f5f5f5;
            opacity: 0.95;
        }
        .dashboard-banner-cta {
            background: linear-gradient(90deg, #17635c 60%, #1b7c6e 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.7rem 2.1rem;
            border-radius: 2rem;
            border: none;
            box-shadow: 0 4px 16px rgba(23,99,92,0.13);
            transition: background .2s, color .2s, box-shadow .2s, transform .2s;
            letter-spacing: 1px;
            outline: none;
        }
        .dashboard-banner-cta:hover, .dashboard-banner-cta:focus {
            background: linear-gradient(90deg, #1b7c6e 60%, #17635c 100%);
            color: #fff;
            box-shadow: 0 8px 32px rgba(23,99,92,0.18);
            transform: scale(1.07);
        }
        .dashboard-banner-badge {
            display: none;
        }
        @media (max-width: 991.98px) {
            .dashboard-banner { flex-direction: column; align-items: flex-start; padding: 2rem 1rem; }
        }

        .dashboard-section {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(0,104,74,0.07);
            padding: 2.2rem 1.2rem 2.2rem 1.2rem;
            margin-bottom: 2.5rem;
        }
        .dashboard-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.7rem;
        }
        .dashboard-section-title {
            color: #00684A;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .dashboard-section-link {
            color: #009F5B;
            font-weight: 600;
            text-decoration: none;
            font-size: 1.05rem;
            transition: color .2s;
        }
        .dashboard-section-link:hover { color: #00684A; text-decoration: underline; }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 produk per baris */
            gap: 0.7rem;
        }
        @media (max-width: 1200px) {
            .product-grid { grid-template-columns: repeat(4, 1fr); }
        }
        @media (max-width: 991.98px) {
            .product-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 700px) {
            .product-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .product-grid { grid-template-columns: 1fr; }
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,104,74,0.08);
            padding: 0.8rem 0.7rem 0.8rem 0.7rem; /* lebih kecil */
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow .2s, transform .2s;
            border: 1.5px solid #E6F4EA;
            max-width: 210px; /* lebih kecil */
        }
        .product-card:hover { box-shadow: 0 8px 32px rgba(0,104,74,0.13); transform: translateY(-4px) scale(1.03); border-color: #009F5B; }
        .product-label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            font-size: 0.92rem;
            font-weight: 700;
            border-radius: 1rem;
            padding: 0.3em 1em;
            color: #00684A;
            background: #E6F4EA;
            z-index: 2;
        }
        .product-label.sale {
            background: #FDECEC;
            color: #E74C3C;
        }
        .product-img {
            max-width: 100px; /* lebih kecil */
            height: 80px; /* lebih kecil */
            margin-bottom: 0.7rem;
            margin-top: 0.5rem;
        }
        .product-title {
            font-size: 0.98rem;
        }
        .product-desc {
            font-size: 0.9rem;
            min-height: 28px;
        }
        .product-prices {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            margin-bottom: 0.8rem;
            justify-content: center;
        }
        .product-oldprice {
            text-decoration: line-through;
            color: #999;
            font-size: 1.01rem;
        }
        .product-price {
            color: #009F5B;
            font-weight: 700;
            font-size: 1.13rem;
        }
        .product-card .btn-rent {
            background: #009F5B;
            color: #fff;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 0.6rem 1.7rem;
            border: none;
            margin-top: 0.5rem;
            transition: background .2s, color .2s, box-shadow .2s, transform .2s;
            box-shadow: 0 2px 8px #E6F4EA;
        }
        .product-card .btn-rent:hover, .product-card .btn-rent:focus {
            background: #00684A;
            color: #fff;
            box-shadow: 0 4px 16px #009F5B33;
            transform: scale(1.06);
        }
        .btn-rent, .btn-primary, .btn-sewa {
            background: linear-gradient(90deg, #17635c 60%, #1b7c6e 100%) !important;
            color: #fff !important;
            font-weight: 700;
            border-radius: 2rem;
            border: none;
            box-shadow: 0 4px 16px rgba(23,99,92,0.13);
            transition: background .2s, color .2s, box-shadow .2s, transform .2s;
        }
        .btn-rent:hover, .btn-primary:hover, .btn-sewa:hover,
        .btn-rent:focus, .btn-primary:focus, .btn-sewa:focus {
            background: linear-gradient(90deg, #1b7c6e 60%, #17635c 100%) !important;
            color: #fff !important;
            box-shadow: 0 8px 32px rgba(23,99,92,0.18);
            transform: scale(1.04);
        }
        .hero-banner-anim {
            cursor: pointer;
        }
        .hero-banner-anim:hover, .hero-banner-anim:focus {
            box-shadow: 0 8px 32px rgba(23,99,92,0.18), 0 2px 16px 0 rgba(0,0,0,0.10);
            transform: scale(1.025) translateY(-4px);
            z-index: 2;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    {{-- @include('components.user-topbar') --}}
    <main class="col-12 main-content px-0 py-3" id="mainContentUser" style="transition:padding-left 0.4s cubic-bezier(.4,2,.6,1);">
        <!-- Banner Promo -->
        <div class="dashboard-banner mb-4" style="background: url('/images/Screenshot 2025-07-02 011227.png') center center/cover no-repeat; min-height: 240px; transition: box-shadow .3s;">
            <div class="dashboard-banner-content" style="color: #fff; text-shadow: 0 2px 8px rgba(0,0,0,0.18);">
                <div class="dashboard-banner-title">Karena setiap perjalanan butuh persiapan yang tepat</div>
                <div class="dashboard-banner-desc">RDOUTDOOR hadir untuk menemani petualanganmu dengan perlengkapan berkualitas dan layanan praktis.</div>
                <a href="#new-arrival" class="dashboard-banner-cta">Belanja Sekarang</a>
            </div>
        </div>
        <!-- New Arrival Section -->
        <div class="dashboard-section">
            <div class="dashboard-section-header">
                <div class="dashboard-section-title">Produk Terbaru</div>
                {{-- <a href="{{ route('products.all') }}" class="dashboard-section-link">Lihat semua &rarr;</a> --}}
            </div>
            <div class="product-grid" id="new-arrival">
                @if(isset($products) && $products->count())
                    @foreach($products as $product)
                        <div class="product-card">
                            @if(isset($product->is_new) && $product->is_new)
                                <span class="product-label">Baru</span>
                            @elseif(isset($product->is_sale) && $product->is_sale)
                                <span class="product-label sale">Promo</span>
                            @endif
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/produk/default.jpg') }}" class="product-img" alt="{{ $product->name }}">
                            <div class="product-title">{{ $product->name }}</div>
                            <div class="product-desc">Stok: <b>{{ $product->stock }}</b> item</div>
                            <div class="product-prices">
                                @if(isset($product->old_price) && $product->old_price > $product->price)
                                    <span class="product-oldprice">Rp{{ number_format($product->old_price,0,',','.') }}</span>
                                @endif
                                <span class="product-price">Rp{{ number_format($product->price,0,',','.') }}</span>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" class="w-100 mt-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-outline-success w-100"><i class="bi bi-cart-plus"></i> Tambah ke Keranjang</button>
                            </form>
                            <a href="{{ route('checkout.form', ['product_id' => $product->id, 'qty' => 1]) }}" class="btn btn-rent w-100 mt-2">Sewa Sekarang</a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info text-center">Belum ada produk baru.</div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Order User (opsional, jika ingin tampilkan order user seperti admin) -->
        @if(isset($latestOrders))
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                Order Terbaru
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Tanggal Sewa</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($order->orderItems->count())
                                        {{ $order->orderItems->first()->product->name ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($order->start_date && $order->end_date)
                                        {{ $order->start_date }} s/d {{ $order->end_date }}
                                    @else
                                        {{ $order->order_date }}
                                    @endif
                                </td>
                                <td>Rp{{ number_format($order->total_price,0,',','.') }}</td>
                                <td>
                                    @php
                                        $badge = 'secondary';
                                        if ($order->status === 'pending') $badge = 'warning';
                                        elseif ($order->status === 'selesai') $badge = 'success';
                                        elseif ($order->status === 'batal') $badge = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada order.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Hero section mulai di bawah sini -->
        <div class="hero-section">
            <!-- ...isi hero section... -->
        </div>

        <!-- Pastikan tidak ada overflow: hidden pada parent dropdown -->
    </main>
</div>
@endsection
