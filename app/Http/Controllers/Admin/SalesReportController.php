<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\StreamedResponse;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportCsv(Request $request): StreamedResponse
    {
        $from = Carbon::parse($request->input('from', now()->subDays(30)->format('Y-m-d')))->startOfDay();
        $to = Carbon::parse($request->input('to', now()->format('Y-m-d')))->endOfDay();

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
            ->groupBy('products.id', 'products.name', 'products.price')
            ->select('products.name', 'products.price')
            ->selectRaw('SUM(order_items.quantity) as qty_sold')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue')
            ->orderByDesc('total_revenue')
            ->get();

        $filename = 'sales-report-' . $from->format('Y-m-d') . '-to-' . $to->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return new StreamedResponse(function () use ($from, $to, $dailySales, $topProducts) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, ['PulseTrade Sales Report']);
            fputcsv($handle, ['Period', $from->format('M d, Y') . ' — ' . $to->format('M d, Y')]);
            fputcsv($handle, []);

            // Summary
            $totalRevenue = $dailySales->sum('revenue');
            $totalOrders = $dailySales->sum('orders');
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            fputcsv($handle, ['Summary']);
            fputcsv($handle, ['Total Revenue', number_format($totalRevenue, 2)]);
            fputcsv($handle, ['Total Paid Orders', $totalOrders]);
            fputcsv($handle, ['Average Order Value', number_format($avgOrderValue, 2)]);
            fputcsv($handle, []);

            // Daily sales
            fputcsv($handle, ['Daily Sales']);
            fputcsv($handle, ['Date', 'Orders', 'Revenue']);
            foreach ($dailySales as $day) {
                fputcsv($handle, [
                    Carbon::parse($day->date)->format('M d, Y'),
                    $day->orders,
                    number_format($day->revenue, 2),
                ]);
            }
            fputcsv($handle, []);

            // Top products
            fputcsv($handle, ['Top Products']);
            fputcsv($handle, ['Product', 'Qty Sold', 'Revenue']);
            foreach ($topProducts as $product) {
                fputcsv($handle, [
                    $product->name,
                    $product->qty_sold,
                    number_format($product->total_revenue, 2),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function exportPdf(Request $request)
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
            ->groupBy('products.id', 'products.name', 'products.price')
            ->select('products.name', 'products.price')
            ->selectRaw('SUM(order_items.quantity) as qty_sold')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue')
            ->orderByDesc('total_revenue')
            ->get();

        $currencySymbol = Setting::get('store_currency', 'USD');
        $symbols = [
            'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'JPY' => '¥', 'INR' => '₹', 'BDT' => '৳',
        ];
        $currencySymbol = $symbols[strtoupper($currencySymbol)] ?? '$';

        $pdf = Pdf::loadView('admin.reports.sales-pdf', compact(
            'totalRevenue', 'totalOrders', 'paidOrders', 'avgOrderValue',
            'dailySales', 'topProducts', 'from', 'to', 'currencySymbol'
        ));

        $pdf->setPaper('a4', 'portrait');

        $filename = 'sales-report-' . $from->format('Y-m-d') . '-to-' . $to->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
