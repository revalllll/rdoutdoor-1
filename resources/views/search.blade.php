{{-- resources/views/search.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-4">Hasil Pencarian: <span class="text-primary">{{ $q }}</span></h1>
    @if($products->count())
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            <div class="fw-bold mb-2">Rp{{ number_format($product->price,0,',','.') }}</div>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">Tidak ditemukan alat outdoor dengan kata kunci tersebut.</div>
    @endif
</div>
@endsection
