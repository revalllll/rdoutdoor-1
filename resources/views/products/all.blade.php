@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-2xl font-bold text-green-900">Semua Produk</h1>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/produk/default.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Rp{{ number_format($product->price,0,',','.') }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-success">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Belum ada produk.</div>
        @endforelse
    </div>
</div>
@endsection
