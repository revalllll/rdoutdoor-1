{{-- filepath: resources/views/admin/products/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="col-lg-6 mx-auto">
    <h1 class="h4 mb-4">Detail Produk</h1>
    <div class="mb-3">
        <strong>Nama Produk:</strong> {{ $product->name }}
    </div>
    <div class="mb-3">
        <strong>Harga Sewa:</strong> Rp{{ number_format($product->price,0,',','.') }}
    </div>
    <div class="mb-3">
        <strong>Stok:</strong> {{ $product->stock }}
    </div>
    <div class="mb-3">
        <strong>Kategori:</strong> {{ $product->category ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Foto Produk:</strong><br>
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:200px;max-height:200px;object-fit:cover;">
        @else
            <span class="text-muted">Tidak ada gambar</span>
        @endif
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection