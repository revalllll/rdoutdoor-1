{{-- filepath: resources/views/admin/orders/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Daftar Order</h1>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari customer/produk..." value="{{ request('search') }}">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                <option value="selesai" @if(request('status')=='selesai') selected @endif>Selesai</option>
                <option value="batal" @if(request('status')=='batal') selected @endif>Batal</option>
            </select>
            <button class="btn btn-outline-primary">Filter</button>
        </form>
    </div>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary mb-3">Tambah Order</a>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Nama Customer</th>
                <th>Alat Disewa</th>
                <th>Tanggal Sewa</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($order->orderItems->count())
                        {{ $order->orderItems->first()->product->name ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $order->customer_name }}</td>
                <td>
                    @if($order->orderItems->count())
                        <ul class="mb-0 ps-3">
                        @foreach($order->orderItems as $item)
                            <li>{{ $item->product->name ?? '-' }} ({{ $item->quantity }})</li>
                        @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($order->start_date && $order->end_date)
                        {{ $order->start_date }} s/d {{ $order->end_date }}
                    @else
                        {{ $order->order_date }}
                    @endif
                </td>
                <td>Rp{{ number_format($order->total_price,0,',','.') }}</td>
                <td>
                    @php
                        $badge = 'secondary';
                        if ($order->status === 'pending') $badge = 'warning';
                        elseif ($order->status === 'selesai') $badge = 'success';
                        elseif ($order->status === 'batal') $badge = 'danger';
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                </td>
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
<script>
document.querySelectorAll('form[action*="destroy"]').forEach(form => {
    form.onsubmit = function(e) {
        if(!confirm('Yakin ingin menghapus order ini?')) e.preventDefault();
    };
});
</script>
@endsection