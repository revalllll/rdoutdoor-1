@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width:500px;">
        <div class="card-body text-center">
            <h3 class="mb-4">Pembayaran Midtrans</h3>
            <div class="mb-3">
                <strong>Order Number:</strong> {{ $order->order_number }}<br>
                <strong>Total Tagihan:</strong> Rp{{ number_format($order->total_price,0,',','.') }}
            </div>
            <button id="pay-button" class="btn btn-success btn-lg">Bayar dengan Midtrans</button>
        </div>
    </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').onclick = function(){
  window.snap.pay('{{ $snapToken }}');
};
</script>
@endsection
