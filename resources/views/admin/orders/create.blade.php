{{-- filepath: resources/views/admin/orders/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Tambah Order</h1>
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Order Number</label>
            <input type="text" name="order_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Total</label>
            <input type="number" name="total" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Order Date</label>
            <input type="date" name="order_date" class="form-control" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection