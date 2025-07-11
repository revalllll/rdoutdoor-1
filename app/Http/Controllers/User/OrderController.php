<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $product = Product::findOrFail($request->product_id);
        // Buat order sederhana (bisa dikembangkan)
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total_price' => $product->price,
            'status' => 'pending',
            'order_date' => now(),
        ]);
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);
        // Tampilkan halaman checkout setelah order dibuat
        return view('orders.checkout', [
            'order' => $order,
            'user' => Auth::user()
        ]);
    }
}
