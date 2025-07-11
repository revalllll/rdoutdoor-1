@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width:500px;">
        <div class="card-body">
            <h3 class="mb-4 text-center">Pilih Metode Pembayaran</h3>
            <div class="mb-3">
                <strong>Order Number:</strong> {{ $order->order_number }}<br>
                <strong>Total Tagihan:</strong> Rp{{ number_format($order->total_price,0,',','.') }}
            </div>
            <form>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="bca" checked>
                    <label class="form-check-label" for="bca">BCA Virtual Account</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="mandiri">
                    <label class="form-check-label" for="mandiri">Mandiri Virtual Account</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="bri">
                    <label class="form-check-label" for="bri">BRI Virtual Account</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="alfamart">
                    <label class="form-check-label" for="alfamart">Alfamart / Lawson / Dan+Dan</label>
                </div>
                <button type="submit" class="btn btn-success w-100 mt-3">Bayar Sekarang</button>
            </form>
        </div>
    </div>
</div>
@endsection
