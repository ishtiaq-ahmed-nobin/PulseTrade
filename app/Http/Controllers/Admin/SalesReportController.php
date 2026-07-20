<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse($request->input('from', now()->subDays(30)->format('Y-m-d')))->startOfDay();
        $to = Carbon::parse($request->input('to', now()->format('Y-m-d')))->endOfDay();

        $totalRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$from, $to])
            ->sum('total_amount');

        $totalOrders = Order::whereBetween('created_at', [$from, $to])->count();
        $paidOrders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$from, $to])->count();
        $avgOrderValue = $paidOrders > 0 ? $totalRevenue / $paidOrders : 0;

        $dailySales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$from, $to])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$from, $to])
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->select('products.id', 'products.name', 'products.image', 'products.price')
            ->selectRaw('SUM(order_items.quantity) as qty_sold')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue')
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get();

        return view('admin.reports.sales', compact(
            'totalRevenue', 'totalOrders', 'paidOrders', 'avgOrderValue',
            'dailySales', 'topProducts', 'from', 'to'
        ));
    }
}
