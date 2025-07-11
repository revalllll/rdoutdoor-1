<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeOrders = Order::where('customer_name', $user->name)
            ->where('status', 'pending')
            ->orderBy('order_date', 'desc')
            ->get();
        $completedOrders = Order::where('customer_name', $user->name)
            ->where('status', 'selesai')
            ->orderBy('order_date', 'desc')
            ->get();
        $notifications = []; // Placeholder, bisa diisi notifikasi pembayaran, dsb
        $products = Product::where('is_deleted', 0)
            ->where('status', 1)
            ->orderBy('created_date', 'desc')
            ->limit(8)
            ->get();
        return view('user.dashboard', compact('activeOrders', 'completedOrders', 'notifications', 'products'));
    }
}
