@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/produk/default.jpg') }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold mb-2" style="color:#00684A">{{ $product->name }}</h2>
            <div class="mb-2">
                @if(isset($product->is_new) && $product->is_new)
                    <span class="badge" style="background:#E6F4EA;color:#00684A;font-weight:600;">Baru</span>
                @elseif(isset($product->is_sale) && $product->is_sale)
                    <span class="badge" style="background:#FDECEC;color:#E74C3C;font-weight:600;">Promo</span>
                @endif
            </div>
            <div class="mb-3" style="color:#666;">Stok: <b>{{ $product->stock }}</b> item</div>
            <div class="mb-3">
                @if(isset($product->old_price) && $product->old_price > $product->price)
                    <span style="text-decoration:line-through;color:#999;font-size:1.1rem;">Rp{{ number_format($product->old_price,0,',','.') }}</span>
                @endif
                <span class="fw-bold" style="color:#009F5B;font-size:1.3rem;">Rp{{ number_format($product->price,0,',','.') }}</span>
            </div>
            <div class="mb-4" style="color:#333;font-size:1.08rem;">{{ $product->description ?? 'Perlengkapan outdoor berkualitas.' }}</div>
            <a href="{{ route('checkout.form', ['product_id[]' => $product->id, 'qty[]' => 1]) }}" class="btn" style="background:#009F5B;color:#fff;font-weight:700;border-radius:2rem;padding:0.7rem 2.2rem;display:inline-block;text-align:center;">Sewa Sekarang</a>
        </div>
    </div>
</div>
@endsection
