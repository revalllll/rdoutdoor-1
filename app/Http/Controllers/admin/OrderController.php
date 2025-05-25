<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_date', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->last_update_by = Auth::user()->name;
        $order->last_update_date = now();
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order updated!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->is_deleted = 1;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted!');
    }
}