<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'customer')->count();
        $lowStockCount = Product::where('stock', '<', 5)->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::withCount('reviews')
            ->withSum('reviews', 'rating')
            ->orderByDesc('reviews_count')
            ->take(5)
            ->get();

        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'lowStockCount',
            'pendingOrders',
            'recentOrders',
            'topProducts',
            'monthlyRevenue'
        ));
    }
}
