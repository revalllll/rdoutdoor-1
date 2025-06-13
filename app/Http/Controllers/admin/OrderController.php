<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('orderItems.product')->orderBy('CreatedDate', 'desc');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%$search%")
                  ->orWhereHas('orderItems.product', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%") ;
                  });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->get();
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
        $data = $request->validate([
            'order_number' => 'required|string|max:32',
            'customer_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,selesai,batal',
        ]);
        $order->order_number = $data['order_number'];
        $order->customer_name = $data['customer_name'];
        $order->address = $data['address'];
        $order->total_price = $data['total'];
        $order->order_date = $data['order_date'];
        $order->status = $data['status']; // status order (pending, selesai, batal)
        $order->LastUpdateBy = Auth::user()->name;
        $order->LastUpdateDate = now();
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order updated!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // Hapus order items terkait
        $order->orderItems()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus!');
    }

    public function create()
    {
        $products = \App\Models\Product::where('is_deleted', 0)->where('status', 1)->get();
        return view('admin.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_number' => 'required|string|max:32',
            'customer_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'product_id' => 'required|array',
            'product_id.*' => ['required', 'exists:products,id'],
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'start_date' => 'required|array',
            'start_date.*' => 'required|date',
            'end_date' => 'required|array',
            'end_date.*' => ['required','date','after_or_equal:start_date.*'],
        ]);

        // Validasi tanggal sewa tidak bentrok untuk produk yang sama
        foreach ($data['product_id'] as $i => $productId) {
            $start = $data['start_date'][$i];
            $end = $data['end_date'][$i];
            $overlap = \App\Models\OrderItem::where('product_id', $productId)
                ->whereHas('order', function($q) use ($start, $end) {
                    $q->where('Status', 1)
                      ->where(function($q2) use ($start, $end) {
                          $q2->where('start_date', '<=', $end)
                             ->where('end_date', '>=', $start);
                      });
                })
                ->exists();
            if ($overlap) {
                return back()->withErrors(['start_date' => 'Tanggal sewa bentrok dengan order lain untuk produk yang sama!'])->withInput();
            }
        }

        $total = 0;
        $orderItems = [];
        foreach ($data['product_id'] as $i => $productId) {
            $product = \App\Models\Product::findOrFail($productId);
            $qty = $data['quantity'][$i];
            $start = $data['start_date'][$i];
            $end = $data['end_date'][$i];
            $days = (strtotime($end) - strtotime($start)) / (60*60*24) + 1;
            if ($days < 1) $days = 1;
            $subtotal = $product->price * $qty * $days;
            if ($product->stock < $qty) {
                return back()->withErrors(['quantity' => 'Stok produk ' . $product->name . ' tidak mencukupi!']);
            }
            $product->stock -= $qty;
            $product->save();
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price,
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }
        $order = new Order();
        $order->order_number = $data['order_number'];
        $order->customer_name = $data['customer_name'];
        $order->address = $data['address'];
        $order->total_price = $total;
        $order->order_date = $data['start_date'][0];
        $order->start_date = $data['start_date'][0];
        $order->end_date = $data['end_date'][0];
        $order->status = 'pending'; // Set status default pending
        $order->CompanyCode = 'RDO001';
        $order->IsDeleted = 0;
        $order->CreatedBy = Auth::user()->name;
        $order->CreatedDate = now();
        $order->LastUpdateBy = Auth::user()->name;
        $order->LastUpdateDate = now();
        $order->save();
        foreach ($orderItems as $item) {
            $item['order_id'] = $order->id;
            \App\Models\OrderItem::create($item);
        }
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil ditambahkan');
    }
}