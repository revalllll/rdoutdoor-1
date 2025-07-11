@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm mx-auto" style="max-width:500px;">
        <div class="card-body">
            <h2 class="mb-3 text-success">Pembayaran Berhasil!</h2>
            <p class="mb-4">Terima kasih, pembayaran Anda sudah diproses.<br>Silakan cek status pesanan di halaman <a href="{{ route('orders.index') }}">Pesanan Saya</a>.</p>
            <a href="{{ route('orders.index') }}" class="btn btn-success">Lihat Pesanan</a>
        </div>
    </div>
</div>
@endsection
