{{-- filepath: resources/views/admin/products/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="col-lg-6 mx-auto">
    <h1 class="h4 mb-4">Edit Produk</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
        </div>
        <div class="mb-3">
            <label>Harga Sewa</label>
            <input type="number" name="price" class="form-control" required value="{{ old('price', $product->price) }}">
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" required value="{{ old('stock', $product->stock) }}">
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection