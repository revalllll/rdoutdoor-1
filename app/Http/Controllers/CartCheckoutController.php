<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartCheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);
        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'customer_phone' => $request->phone,
            'total_price' => $total,
            'status' => 'pending',
            'order_date' => now(),
            'CompanyCode' => 'RDO001',
            'CreatedBy' => Auth::user()->name ?? 'guest',
            'CreatedDate' => now(),
            'LastUpdateBy' => Auth::user()->name ?? 'guest',
            'LastUpdateDate' => now(),
        ]);
        foreach ($products as $product) {
            // Ambil tanggal sewa dari request jika ada
            $start = $request->input('products.' . $product->id . '.start_date');
            $end = $request->input('products.' . $product->id . '.end_date');
            $qty = $cart[$product->id];
            $days = 1;
            if ($start && $end) {
                $days = (strtotime($end) - strtotime($start)) / (60*60*24) + 1;
                if ($days < 1) $days = 1;
            }
            $subtotal = $product->price * $qty * $days;
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price,
                'subtotal' => $subtotal,
                'start_date' => $start,
                'end_date' => $end,
            ]);
        }
        Session::forget('cart');
        return redirect()->route('midtrans.pay', ['order' => $order->id])->with('success', 'Order berhasil dibuat, silakan lanjutkan pembayaran.');
    }

    public function show(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        $products = Product::whereIn('id', array_keys($cart))->get();
        $user = Auth::user();
        // Ambil tanggal dari request jika ada, mapping ke product_id
        $dates = [];
        $startDates = (array) $request->input('start_date', []);
        $endDates = (array) $request->input('end_date', []);
        $i = 0;
        foreach ($products as $product) {
            $dates[$product->id]['start_date'] = $startDates[$i] ?? '';
            $dates[$product->id]['end_date'] = $endDates[$i] ?? '';
            $i++;
        }
        return view('cart.checkout', compact('products', 'cart', 'user', 'dates'));
    }
}
