{{-- filepath: resources/views/admin/orders/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Daftar Order</h1>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary mb-3">Tambah Order</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Order Number</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>Rp{{ number_format($order->total,0,',','.') }}</td>
                <td>{{ $order->order_date }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection