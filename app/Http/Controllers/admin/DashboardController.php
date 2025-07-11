<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total order: hanya order yang tidak batal
        $totalOrders = Order::where('status', '!=', 'batal')->count();
        // Total penjualan: hanya order yang selesai
        $totalSales = Order::where('status', 'selesai')->sum('total_price');
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $latestOrders = Order::with('orderItems.product')->orderBy('CreatedDate', 'desc')->limit(5)->get();

        // Chart filter
        $filter = $request->get('chart_filter', 'monthly');
        $chartLabels = [];
        $chartData = [];
        if ($filter === 'daily') {
            // 14 hari terakhir
            $ordersPerDay = Order::selectRaw('DATE(CreatedDate) as date, COUNT(*) as total')
                ->where('status', '!=', 'batal')
                ->where('CreatedDate', '>=', Carbon::now()->subDays(13)->startOfDay())
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            for ($i = 13; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $label = $date->format('d M');
                $chartLabels[] = $label;
                $found = $ordersPerDay->first(fn($item) => $item->date == $date->toDateString());
                $chartData[] = $found ? $found->total : 0;
            }
        } elseif ($filter === 'weekly') {
            // 8 minggu terakhir
            $ordersPerWeek = Order::selectRaw('YEAR(CreatedDate) as year, WEEK(CreatedDate, 1) as week, COUNT(*) as total')
                ->where('status', '!=', 'batal')
                ->where('CreatedDate', '>=', Carbon::now()->subWeeks(7)->startOfWeek())
                ->groupBy('year', 'week')
                ->orderBy('year')
                ->orderBy('week')
                ->get();
            for ($i = 7; $i >= 0; $i--) {
                $date = Carbon::now()->subWeeks($i);
                $label = 'Minggu ' . $date->format('W') . ' ' . $date->format('Y');
                $chartLabels[] = $label;
                $found = $ordersPerWeek->first(fn($item) => $item->year == $date->year && $item->week == $date->format('W'));
                $chartData[] = $found ? $found->total : 0;
            }
        } else {
            // Bulanan (12 bulan terakhir)
            $ordersPerMonth = Order::selectRaw('YEAR(CreatedDate) as year, MONTH(CreatedDate) as month, COUNT(*) as total')
                ->where('status', '!=', 'batal')
                ->where('CreatedDate', '>=', Carbon::now()->subMonths(11)->startOfMonth())
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $label = $date->format('M Y');
                $chartLabels[] = $label;
                $found = $ordersPerMonth->first(fn($item) => $item->year == $date->year && $item->month == $date->month);
                $chartData[] = $found ? $found->total : 0;
            }
        }

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'orderCount' => $totalOrders, // alias agar tidak error di view
            'totalSales' => $totalSales,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'latestOrders' => $latestOrders,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}