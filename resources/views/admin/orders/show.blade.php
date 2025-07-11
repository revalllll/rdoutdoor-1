{{-- filepath: resources/views/admin/orders/show.blade.php --}}
@extends('layouts.admin')

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
        <strong>Total:</strong> Rp{{ number_format($order->total_price,0,',','.') }}
    </div>
    <div class="mb-3">
        <strong>Order Date:</strong> {{ $order->order_date }}
    </div>
    <div class="mb-3">
        <strong>Tanggal Sewa:</strong>
        @if($order->start_date && $order->end_date)
            {{ $order->start_date }} s/d {{ $order->end_date }}
        @else
            {{ $order->order_date }}
        @endif
    </div>
    <div class="mb-3">
        <strong>Status:</strong>
        @php
            $label = $order->status_label;
            $badge = $order->status_badge;
        @endphp
        <span class="badge bg-{{ $badge }}">{{ $label }}</span>
    </div>
    <div class="mb-3">
        <strong>Alamat Penyewa:</strong> {{ $order->address }}
    </div>
    <div class="mb-3">
        <strong>Order Items:</strong>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp{{ number_format($item->price,0,',','.') }}</td>
                    <td>Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection