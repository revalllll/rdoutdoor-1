<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function index($id)
    {
        // Ambil data user (pakai Auth jika login, fallback dummy)
        $user = auth()->user();
        if (!$user) {
            $user = (object) [
                'name' => 'Guest',
                'address' => '',
            ];
        }
        // Ambil data produk dari database
        $product = Product::findOrFail($id);
        // Dummy shipping, payment, promo
        $shipping = (object) [
            'service' => 'J&T',
            'cost' => 12000,
            'estimate' => '10 - 13 Jul',
        ];
        $payments = [
            (object) ['id' => 'bca', 'name' => 'BCA Virtual Account'],
            (object) ['id' => 'alfamart', 'name' => 'Alfamart / Alfamidi / Lawson / Dan+Dan'],
            (object) ['id' => 'mandiri', 'name' => 'Mandiri Virtual Account'],
            (object) ['id' => 'bri', 'name' => 'BRI Virtual Account'],
        ];
        $promo = (object) [
            'cashback' => 23900,
        ];
        $total = $product->price + 12150 + 12000 - 23900;

        // Ambil produk yang aktif & tidak dihapus untuk dropdown
        $produkList = Product::where('status', 1)
            ->where(function($q){ $q->where('is_deleted', 0)->orWhereNull('is_deleted'); })
            ->get(['id','name','price']);

        return view('checkout', compact('user', 'product', 'shipping', 'payments', 'promo', 'total', 'produkList'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        // Ambil data produk, qty, tanggal dari form jika ada
        $productIds = (array) $request->input('product_id', []);
        $qtys = (array) $request->input('qty', []);
        $startDates = (array) $request->input('start_date', []);
        $endDates = (array) $request->input('end_date', []);
        $productsArr = [];
        $totalHarga = 0;
        if (!empty($productIds) && !empty($qtys)) {
            $products = \App\Models\Product::whereIn('id', $productIds)->get();
            foreach ($products as $i => $product) {
                $qty = isset($qtys[$i]) ? (int)$qtys[$i] : 1;
                $start = $startDates[$i] ?? null;
                $end = $endDates[$i] ?? null;
                $days = 1;
                if ($start && $end) {
                    $days = (strtotime($end) - strtotime($start)) / (60*60*24) + 1;
                    if ($days < 1) $days = 1;
                }
                $subtotal = $product->price * $qty * $days;
                $totalHarga += $subtotal;
                $productsArr[] = [
                    'id' => $product->id,
                    'qty' => $qty,
                    'start_date' => $start,
                    'end_date' => $end,
                ];
            }
            // Simpan ke session
            session(['checkout_products' => $productsArr, 'checkout_total_harga' => $totalHarga]);
        }
        $products = session('checkout_products', []);
        $totalHarga = session('checkout_total_harga', 0);
        // Validasi hanya untuk data customer
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_address' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);
        if (empty($products) || $totalHarga < 1) {
            return redirect()->route('cart.index')->with('error', 'Data checkout tidak ditemukan. Silakan ulangi proses dari keranjang atau produk.');
        }
        $orderNumber = 'ORD' . date('YmdHis') . rand(100,999);
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'address' => $validated['customer_address'],
            'customer_phone' => $validated['customer_phone'],
            'total_price' => $totalHarga,
            'order_date' => now(),
            'status' => 'pending',
            'CompanyCode' => 'RDO001',
            'IsDeleted' => 0,
            'CreatedBy' => $user->name,
            'CreatedDate' => now(),
            'LastUpdateBy' => $user->name,
            'LastUpdateDate' => now(),
        ]);
        foreach ($products as $item) {
            $product = \App\Models\Product::find($item['id']);
            $price = $product->price;
            $days = 1;
            if (isset($item['start_date']) && isset($item['end_date'])) {
                $days = (strtotime($item['end_date']) - strtotime($item['start_date'])) / (60*60*24) + 1;
                if ($days < 1) $days = 1;
            }
            $subtotal = $price * $item['qty'] * $days;
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $price,
                'subtotal' => $subtotal,
            ]);
        }
        // Bersihkan session checkout
        session()->forget(['checkout_products', 'checkout_total_harga']);
        return redirect()->route('midtrans.pay', ['order' => $order->id])->with('success', 'Checkout berhasil! Silakan pilih metode pembayaran.');
    }

    public function paymentMethod($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        // Anda bisa menambahkan data pembayaran/metode pembayaran di sini
        return view('payment.method', compact('order'));
    }

    public function payWithMidtrans($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone' => $order->customer_phone ?? '',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('payment.midtrans', compact('snapToken', 'order'));
    }

    public function show(Request $request)
    {
        if ($request->isMethod('post')) {
            // Simpan data produk ke session
            session(['checkout_products' => $request->input('products')]);
            return redirect()->route('checkout.show');
        }
        $user = auth()->user();
        $products = session('checkout_products', []);
        if (empty($products)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih untuk checkout.');
        }
        $productModels = \App\Models\Product::whereIn('id', array_column($products, 'id'))->get();
        $cart = [];
        foreach ($products as $prod) {
            $cart[$prod['id']] = $prod['qty'];
        }
        return view('orders.checkout', ['user' => $user, 'products' => $productModels, 'cart' => $cart]);
    }

    public function checkoutForm(Request $request)
    {
        $user = auth()->user();
        $productIds = (array) ($request->input('product_id', $request->query('product_id', [])));
        $qtys = (array) ($request->input('qty', $request->query('qty', [])));
        $startDates = (array) ($request->input('start_date', $request->query('start_date', [])));
        $endDates = (array) ($request->input('end_date', $request->query('end_date', [])));

        // Jika belum ada tanggal, arahkan ke halaman checkout form untuk input tanggal
        if (empty($startDates) || empty($endDates)) {
            $products = \App\Models\Product::whereIn('id', $productIds)->get();
            $cart = [];
            foreach ($products as $i => $product) {
                $cart[$product->id] = isset($qtys[$i]) ? (int)$qtys[$i] : 1;
            }
            return view('orders.checkout', [
                'user' => $user,
                'products' => $products,
                'cart' => $cart,
                'dates' => [],
                'totalHarga' => null
            ]);
        }

        // Validasi: semua field harus terisi
        if (empty($productIds) || empty($qtys) || empty($startDates) || empty($endDates)) {
            return redirect()->route('cart.index')->with('error', 'Semua field harus diisi untuk melanjutkan checkout.');
        }
        foreach ($startDates as $date) {
            if (empty($date)) {
                return redirect()->route('cart.index')->with('error', 'Tanggal mulai harus diisi untuk semua produk.');
            }
        }
        foreach ($endDates as $date) {
            if (empty($date)) {
                return redirect()->route('cart.index')->with('error', 'Tanggal selesai harus diisi untuk semua produk.');
            }
        }

        $products = \App\Models\Product::whereIn('id', $productIds)->get();
        $cart = [];
        $dates = [];
        $productsArr = [];
        $totalHarga = 0;
        foreach ($products as $i => $product) {
            $qty = isset($qtys[$i]) ? (int)$qtys[$i] : 1;
            $start = $startDates[$i] ?? null;
            $end = $endDates[$i] ?? null;
            $cart[$product->id] = $qty;
            $dates[$product->id] = [
                'start_date' => $start,
                'end_date' => $end,
            ];
            // Hitung hari sewa
            $days = 1;
            if ($start && $end) {
                $days = (strtotime($end) - strtotime($start)) / (60*60*24) + 1;
                if ($days < 1) $days = 1;
            }
            $subtotal = $product->price * $qty * $days;
            $totalHarga += $subtotal;
            $productsArr[] = [
                'id' => $product->id,
                'qty' => $qty,
                'start_date' => $start,
                'end_date' => $end,
            ];
        }
        // Simpan ke session untuk proses store
        session(['checkout_products' => $productsArr, 'checkout_total_harga' => $totalHarga]);
        return view('orders.checkout', [
            'user' => $user,
            'products' => $products,
            'cart' => $cart,
            'dates' => $dates,
            'totalHarga' => $totalHarga
        ]);
    }
}
