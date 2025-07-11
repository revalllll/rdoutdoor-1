{{-- filepath: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="py-4">
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

    {{-- <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-bold">
            Grafik Order per Bulan
        </div>
        <div class="card-body">
            <canvas id="ordersChart" height="100"></canvas>
        </div>
    </div> --}}

    <div class="card shadow-sm border-0 mb-4 d-block d-md-none">
        <div class="card-header bg-white fw-bold">Order Terbaru</div>
        <div class="card-body p-0">
            @forelse($latestOrders as $order)
                <div class="border rounded mb-3 p-3">
                    <div class="mb-2"><span class="fw-bold">Nama Produk:</span> {{ $order->orderItems->first()->product->name ?? '-' }}</div>
                    <div class="mb-2"><span class="fw-bold">Customer:</span> {{ $order->customer_name }}</div>
                    <div class="mb-2"><span class="fw-bold">Alat Disewa:</span>
                        <ul class="mb-0 ps-3">
                        @foreach($order->orderItems as $item)
                            <li>{{ $item->product->name ?? '-' }} ({{ $item->quantity }})</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="mb-2"><span class="fw-bold">Tanggal Sewa:</span> @if($order->start_date && $order->end_date){{ $order->start_date }} s/d {{ $order->end_date }}@else{{ $order->order_date }}@endif</div>
                    <div class="mb-2"><span class="fw-bold">Total Harga:</span> Rp{{ number_format($order->total_price,0,',','.') }}</div>
                    <div class="mb-2"><span class="fw-bold">Status:</span> <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span></div>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <a href="#" class="btn btn-info btn-sm">Detail</a>
                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#" class="btn btn-secondary btn-sm">Export Resi</a>
                        <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-3">Belum ada order.</div>
            @endforelse
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 d-none d-md-block">
        <div class="card-header bg-white fw-bold">
            Order Terbaru
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Nama Customer</th>
                            <th>Alat Disewa</th>
                            <th>Tanggal Sewa</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
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
                                    $label = $order->status_label;
                                    $badge = $order->status_badge;
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada order.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Script chart dihapus --}}
@endsection

<style>
@media (max-width: 600px) {
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  .table thead th, .table tbody td {
    font-size: 0.92rem;
    white-space: nowrap;
    padding: 0.4rem 0.5rem;
    vertical-align: middle;
  }
  .card-header.fw-bold, h2, h3, h4 {
    font-size: 1.1rem !important;
  }
  .btn, .form-control {
    font-size: 0.98rem !important;
  }
  .sidebar-toggle, .sidebar-btn {
    margin-top: 0.7rem !important;
    z-index: 1001;
  }
  .filter-bar, .mb-4 > .d-flex, .mb-4 > .row {
    margin-bottom: 1rem !important;
  }
}
</style>