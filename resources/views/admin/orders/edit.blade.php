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
            <input type="number" name="total" class="form-control" value="{{ $order->total_price }}" required>
        </div>
        <div class="mb-3">
            <label>Order Date</label>
            <input type="date" name="order_date" class="form-control" value="{{ $order->order_date }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                <option value="selesai" @if($order->status=='selesai') selected @endif>Selesai</option>
                <option value="batal" @if($order->status=='batal') selected @endif>Batal</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Alamat Penyewa</label>
            <textarea name="address" class="form-control" required>{{ old('address', $order->address) }}</textarea>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection