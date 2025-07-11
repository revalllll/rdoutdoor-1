{{-- resources/views/search.blade.php --}}
@extends('layouts.app')

@section('styles')
    @parent
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
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
            padding: 0.8rem 0.7rem 0.8rem 0.7rem;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow .2s, transform .2s;
            border: 1.5px solid #E6F4EA;
            max-width: 210px;
            margin: 0 auto;
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
            max-width: 100px;
            height: 80px;
            margin-bottom: 0.7rem;
            margin-top: 0.5rem;
        }
        .product-title {
            font-size: 0.98rem;
            font-weight: 700;
            color: #00684A;
            margin-bottom: 0.2rem;
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
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <main class="col-12 main-content px-0 py-3">
        <div class="dashboard-section">
            <div class="dashboard-section-header">
                <div class="dashboard-section-title">Hasil Pencarian: <span class="text-primary">{{ $q }}</span></div>
            </div>
            <div class="product-grid">
                @if($products->count())
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
                        <div class="alert alert-warning text-center">Tidak ditemukan alat outdoor dengan kata kunci tersebut.</div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
