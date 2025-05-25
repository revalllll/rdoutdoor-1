{{-- filepath: resources/views/admin/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Detail Order</h1>
    <div class="mb-3">
        <strong>Order Number:</strong> {{ $order->order_number }}
    </div>
    <div class="mb-3">
        <strong>Customer Name:</strong> {{ $order->customer_name }}
    </div>
    <div class="mb-3">
        <strong>Total:</strong> Rp{{ number_format($order->total,0,',','.') }}
    </div>
    <div class="mb-3">
        <strong>Order Date:</strong> {{ $order->order_date }}
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection