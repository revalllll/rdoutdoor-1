{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.app')

@section('styles')
<style>
    .card, .list-group-item, .btn, .badge, .form-control, .rounded-circle {
        transition: box-shadow .2s, transform .2s, background .2s, color .2s, border-color .2s;
    }
    .card:hover, .card:focus {
        box-shadow: 0 8px 32px rgba(23,99,92,0.13) !important;
        transform: scale(1.02);
    }
    .btn-outline-primary:hover, .btn-outline-primary:focus {
        background: #17635c; color: #fff; border-color: #17635c; box-shadow: 0 4px 16px rgba(23,99,92,0.12); transform: scale(1.07); }
    .btn-primary:hover, .btn-primary:focus {
        background: #1b7c6e; color: #fff; box-shadow: 0 4px 16px rgba(23,99,92,0.12); transform: scale(1.07); }
    .badge:hover, .badge:focus {
        box-shadow: 0 2px 8px rgba(23,99,92,0.10); transform: scale(1.08); }
    .form-control:focus, .form-control:hover {
        border-color: #17635c; box-shadow: 0 0 0 0.2rem rgba(23,99,92,.12); transform: scale(1.03); }
    .rounded-circle:hover, .rounded-circle:focus {
        box-shadow: 0 8px 32px rgba(23,99,92,0.18); transform: scale(1.06) rotate(-2deg); }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h1 class="h3 fw-bold mb-4 text-primary">Dashboard Penyewa</h1>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="me-2 text-info"><i class="bi bi-hourglass-split fs-4"></i></span>
                        <h5 class="card-title mb-0">Penyewaan Aktif</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($activeOrders ?? [] as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="#" class="fw-semibold text-decoration-none text-dark">{{ $order->order_number }}</a>
                                    <span class="text-muted small ms-2">({{ $order->order_date }})</span>
                                </div>
                                <span class="badge rounded-pill bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Tidak ada penyewaan aktif.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="me-2 text-success"><i class="bi bi-check-circle fs-4"></i></span>
                        <h5 class="card-title mb-0">Penyewaan Selesai</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($completedOrders ?? [] as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="#" class="fw-semibold text-decoration-none text-dark">{{ $order->order_number }}</a>
                                    <span class="text-muted small ms-2">({{ $order->order_date }})</span>
                                </div>
                                <span class="badge rounded-pill bg-success">{{ ucfirst($order->status) }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada penyewaan selesai.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="me-2 text-primary"><i class="bi bi-bell fs-4"></i></span>
                        <h5 class="card-title mb-0">Notifikasi</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($notifications ?? [] as $notif)
                            <li class="list-group-item">
                                <i class="bi bi-info-circle text-info me-2"></i>{{ $notif }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada notifikasi.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0 mb-4 bg-light">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=100" class="rounded-circle mb-2" width="80" height="80" alt="Avatar">
                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                    <div class="text-muted small mb-2">{{ Auth::user()->email }}</div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
