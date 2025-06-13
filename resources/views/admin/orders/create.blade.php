{{-- filepath: resources/views/admin/orders/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Order')

@section('content')
<div class="container mt-4">
    <h1>Tambah Order</h1>
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
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="order_number" class="form-label">Order Number</label>
            <input type="text" name="order_number" id="order_number" class="form-control" required value="{{ old('order_number') }}">
        </div>
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" required value="{{ old('customer_name') }}">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Alamat Penyewa</label>
            <textarea name="address" id="address" class="form-control" required>{{ old('address') }}</textarea>
        </div>
        <div id="order-items">
            <label class="form-label">Produk & Jumlah</label>
            <div class="row g-2 mb-2 order-item-row">
                <div class="col-md-5">
                    <select name="product_id[]" class="form-control product-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                {{ $product->name }} (Stok: {{ $product->stock }}, Harga: Rp{{ number_format($product->price,0,',','.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="quantity[]" class="form-control quantity-input" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <input type="date" name="start_date[]" class="form-control start-date-input" required value="{{ is_array(old('start_date')) ? old('start_date')[0] : old('start_date', date('Y-m-d')) }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date[]" class="form-control end-date-input" required value="{{ is_array(old('end_date')) ? old('end_date')[0] : old('end_date', date('Y-m-d')) }}">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-item" style="display:none">-</button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-success btn-sm mb-3" id="add-item">+ Tambah Produk</button>
        <div class="mb-3">
            <label for="total" class="form-label">Total Harga</label>
            <input type="number" name="total" id="total" class="form-control" readonly>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.order-item-row').forEach(function(row) {
            const select = row.querySelector('.product-select');
            const price = parseInt(select.options[select.selectedIndex]?.getAttribute('data-price')) || 0;
            const qty = parseInt(row.querySelector('.quantity-input').value) || 1;
            const start = new Date(row.querySelector('.start-date-input').value);
            const end = new Date(row.querySelector('.end-date-input').value);
            let days = (end - start) / (1000 * 60 * 60 * 24) + 1;
            if (isNaN(days) || days < 1) days = 1;
            total += price * qty * days;
        });
        document.getElementById('total').value = total;
    }
    document.getElementById('add-item').onclick = function() {
        const container = document.getElementById('order-items');
        const row = container.querySelector('.order-item-row');
        const clone = row.cloneNode(true);
        clone.querySelectorAll('input, select').forEach(el => {
            if (el.type === 'number' || el.type === 'date') el.value = el.defaultValue || '';
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
        });
        clone.querySelector('.remove-item').style.display = '';
        clone.querySelector('.remove-item').onclick = function() {
            clone.remove();
            calculateTotal();
        };
        container.appendChild(clone);
        calculateTotal();
    };
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.onclick = function() {
            btn.closest('.order-item-row').remove();
            calculateTotal();
        };
    });
    document.getElementById('order-items').addEventListener('input', calculateTotal);
    document.getElementById('order-items').addEventListener('change', calculateTotal);
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection