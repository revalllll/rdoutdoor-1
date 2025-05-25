<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('IsDeleted', 0)->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_number' => 'required|string|max:32',
            'customer_name' => 'required|string|max:100',
            'total' => 'required|numeric|min:0',
            'order_date' => 'required|date',
        ]);
        $data['CompanyCode'] = 'RDO001';
        $data['Status'] = 1;
        $data['IsDeleted'] = 0;
        $data['CreatedBy'] = Auth::user()->name;
        $data['CreatedDate'] = now();
        $data['LastUpdateBy'] = Auth::user()->name;
        $data['LastUpdateDate'] = now();

        Order::create($data);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil ditambahkan');
    }

    public function edit(Order $order)
    {
        if ($order->IsDeleted) abort(404);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->IsDeleted) abort(404);

        $data = $request->validate([
            'order_number' => 'required|string|max:32',
            'customer_name' => 'required|string|max:100',
            'total' => 'required|numeric|min:0',
            'order_date' => 'required|date',
        ]);
        $data['LastUpdateBy'] = Auth::user()->name;
        $data['LastUpdateDate'] = now();

        $order->update($data);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diupdate');
    }

    public function destroy(Order $order)
    {
        $order->update([
            'IsDeleted' => 1,
            'LastUpdateBy' => Auth::user()->name,
            'LastUpdateDate' => now(),
        ]);
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus');
    }
}