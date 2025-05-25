{{-- filepath: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="py-4">
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                        <i class="bi bi-cash-stack fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-muted small">Total Penjualan</div>
                        <div class="fs-4 fw-bold">Rp{{ number_format($totalSales,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                        <i class="bi bi-bag-check fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-muted small">Total Order</div>
                        <div class="fs-4 fw-bold">{{ $orderCount }}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tambahkan statistik lain jika perlu --}}
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-bold">
            Order Terbaru
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Rp{{ number_format($order->total,0,',','.') }}</td>
                            <td>{{ $order->order_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada order.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection