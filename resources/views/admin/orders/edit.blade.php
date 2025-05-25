{{-- filepath: resources/views/admin/orders/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Order</h1>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Order Number</label>
            <input type="text" name="order_number" class="form-control" value="{{ $order->order_number }}" required>
        </div>
        <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control" value="{{ $order->customer_name }}" required>
        </div>
        <div class="mb-3">
            <label>Total</label>
            <input type="number" name="total" class="form-control" value="{{ $order->total }}" required>
        </div>
        <div class="mb-3">
            <label>Order Date</label>
            <input type="date" name="order_date" class="form-control" value="{{ $order->order_date }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection