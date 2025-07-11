@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm mx-auto" style="max-width:500px;">
        <div class="card-body">
            <h2 class="mb-3 text-danger">Pembayaran Gagal</h2>
            <p class="mb-4">Maaf, terjadi kesalahan pada proses pembayaran Anda.<br>Silakan coba lagi atau hubungi admin jika masalah berlanjut.</p>
            <a href="/" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
