@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4" style="max-width: 1100px;">
    <h2 class="mb-4 fw-bold" style="font-size:2rem;">Checkout</h2>
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Alamat Penyewa -->
            <div class="col-lg-7">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-2 text-success fw-bold" style="font-size:1.1rem;">ALAMAT PENYEWA</div>
                        <div class="mb-1 fw-semibold"><i class="bi bi-house-door-fill text-success"></i> Rumah &bull; {{ $user->name }}</div>
                        <div class="text-muted">{{ $user->address ?? '-' }}</div>
                    </div>
                </div>
                <!-- Form Alamat dan Nomor HP -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama Penyewa</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', $user->name ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">Alamat Penyewa</label>
                            <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ old('customer_address', $user->address ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Nomor HP</label>
                            <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{ old('customer_phone', $user->phone ?? '') }}" required>
                        </div>
                    </div>
                </div>
                <!-- Daftar Barang -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-2 fw-bold" style="font-size:1.1rem;">Barang yang Disewa</div>
                        @foreach($products as $i => $product)
                            <div class="d-flex align-items-center mb-3 produk-row" data-price="{{ $product->price }}">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/produk/default.jpg') }}" alt="{{ $product->name }}" style="width:56px;height:56px;object-fit:cover;border-radius:8px;margin-right:16px;">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <div class="text-muted small">Qty: {{ $cart[$product->id] }}</div>
                                </div>
                                <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                <input type="number" name="qty[]" class="form-control input-qty" value="{{ $cart[$product->id] }}" min="1" style="max-width:80px;">
                                <input type="date" name="start_date[]" class="form-control input-start" required style="max-width:160px;" value="{{ $dates[$product->id]['start_date'] ?? '' }}">
                                <input type="date" name="end_date[]" class="form-control input-end" required style="max-width:160px;" value="{{ $dates[$product->id]['end_date'] ?? '' }}">
                                <span class="fw-bold ms-3 produk-subtotal">Rp{{ number_format($product->price * $cart[$product->id],0,',','.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Ringkasan -->
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold">Total Tagihan</span>
                            <span class="fw-bold text-success" style="font-size:1.2rem;" id="total-harga">Rp0</span>
                        </div>
                        <input type="hidden" name="total_harga" id="input-total-harga" value="0">
                        <button class="btn btn-success w-100 fw-bold py-2" style="font-size:1.1rem;">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function updateTotalHarga() {
    let total = 0;
    document.querySelectorAll('.produk-row').forEach(function(row) {
        const price = parseInt(row.getAttribute('data-price')) || 0;
        const qty = parseInt(row.querySelector('.input-qty')?.value || 1);
        const start = row.querySelector('.input-start')?.value;
        const end = row.querySelector('.input-end')?.value;
        let days = 1;
        if (start && end) {
            const d1 = new Date(start);
            const d2 = new Date(end);
            days = (d2 - d1) / (1000 * 60 * 60 * 24) + 1;
            if (isNaN(days) || days < 1) days = 1;
        }
        const subtotal = price * qty * days;
        row.querySelector('.produk-subtotal').innerText = 'Rp' + subtotal.toLocaleString('id-ID');
        total += subtotal;
    });
    document.getElementById('total-harga').innerText = 'Rp' + total.toLocaleString('id-ID');
    document.getElementById('input-total-harga').value = total;
}
document.querySelectorAll('.input-qty, .input-start, .input-end').forEach(function(input) {
    input.addEventListener('input', updateTotalHarga);
    input.addEventListener('change', updateTotalHarga);
});
document.addEventListener('DOMContentLoaded', updateTotalHarga);
</script>
@endpush
