{{-- filepath: resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="col-lg-6 mx-auto">
    <h1 class="h4 mb-4">Tambah Produk</h1>
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label>Harga Sewa</label>
            <input type="number" name="price" class="form-control" required value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" required value="{{ old('stock') }}">
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection