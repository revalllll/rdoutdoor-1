{{-- filepath: resources/views/admin/products/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Daftar Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Produk
    </a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Aksi</th>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga Sewa</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>CreatedBy</th>
                <th>CreatedDate</th>
                <th>LastUpdateBy</th>
                <th>LastUpdateDate</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus produk ini?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:60px;max-height:60px;object-fit:cover;">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>Rp{{ number_format($product->price,0,',','.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category ?? '-' }}</td>
                <td>{{ $product->created_by ?? '-' }}</td>
                <td>{{ $product->created_date ?? '-' }}</td>
                <td>{{ $product->last_update_by ?? '-' }}</td>
                <td>{{ $product->last_update_date ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center text-muted">Belum ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection