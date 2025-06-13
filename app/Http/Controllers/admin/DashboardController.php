<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total order: hanya order yang tidak batal
        $totalOrders = Order::where('status', '!=', 'batal')->count();
        // Total penjualan: hanya order yang selesai
        $totalSales = Order::where('status', 'selesai')->sum('total_price');
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $latestOrders = Order::with('orderItems.product')->orderBy('CreatedDate', 'desc')->limit(5)->get();

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'orderCount' => $totalOrders, // alias agar tidak error di view
            'totalSales' => $totalSales,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'latestOrders' => $latestOrders,
        ]);
    }
}