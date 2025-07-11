@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Keranjang</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(isset($products) && count($products))
        <!-- Tabel untuk desktop -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Aksi</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <form action="{{ route('cart.checkout') }}" method="GET" id="checkout-form-{{ $product->id }}">
                                    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                    <input type="hidden" name="qty[]" value="{{ $cart[$product->id] }}">
                                    {{ $cart[$product->id] }}
                                </form>
                            </td>
                            <td>
                                <input type="date" name="start_date[]" class="form-control" value="{{ request('start_date')[$loop->index] ?? '' }}" form="checkout-form-{{ $product->id }}">
                            </td>
                            <td>
                                <input type="date" name="end_date[]" class="form-control" value="{{ request('end_date')[$loop->index] ?? '' }}" form="checkout-form-{{ $product->id }}">
                            </td>
                            <td>Rp{{ number_format($product->price * $cart[$product->id],0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Card/list untuk mobile -->
        <div class="d-block d-md-none">
            @foreach($products as $product)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold">{{ $product->name }}</div>
                        <form action="{{ route('cart.remove', $product->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                    <div class="mb-2">Jumlah: <span class="fw-semibold">{{ $cart[$product->id] }}</span></div>
                    <div class="mb-2">Harga: <span class="fw-semibold">Rp{{ number_format($product->price * $cart[$product->id],0,',','.') }}</span></div>
                    <div class="mb-2">
                        <label class="form-label mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date[]" class="form-control" value="{{ request('start_date')[$loop->index] ?? '' }}" form="checkout-form-{{ $product->id }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label mb-1">Tanggal Selesai</label>
                        <input type="date" name="end_date[]" class="form-control" value="{{ request('end_date')[$loop->index] ?? '' }}" form="checkout-form-{{ $product->id }}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <form action="{{ route('cart.checkout') }}" method="GET" id="checkout-all-form">
            @foreach($products as $product)
                <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                <input type="hidden" name="qty[]" value="{{ $cart[$product->id] }}">
                <input type="hidden" name="start_date[]" id="start-date-{{ $product->id }}">
                <input type="hidden" name="end_date[]" id="end-date-{{ $product->id }}">
            @endforeach
            <button type="submit" class="btn btn-success mt-3 w-100 w-md-auto">Sewa Semua Produk</button>
        </form>
        <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
            @csrf
            <button class="btn btn-warning w-100 w-md-auto">Kosongkan Keranjang</button>
        </form>
    @else
        <div class="alert alert-info">Keranjang Anda masih kosong.</div>
    @endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutAllForm = document.getElementById('checkout-all-form');
    if (checkoutAllForm) {
        checkoutAllForm.addEventListener('submit', function(e) {
            @foreach($products as $product)
                var startInput = document.querySelector('input[name="start_date[]"][form="checkout-form-{{ $product->id }}"]');
                var endInput = document.querySelector('input[name="end_date[]"][form="checkout-form-{{ $product->id }}"]');
                document.getElementById('start-date-{{ $product->id }}').value = startInput ? startInput.value : '';
                document.getElementById('end-date-{{ $product->id }}').value = endInput ? endInput.value : '';
            @endforeach
        });
    }
});
</script>
@endsection
