<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    // ---------------------------------------------------------------- Dashboard

    public function dashboard(): JsonResponse
    {
        $totalOrders = Order::count();
        $totalRevenue = (float) Order::where('payment_status', 'paid')->sum('total_amount');
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

        return response()->json([
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_products' => $totalProducts,
            'total_users' => $totalUsers,
            'low_stock_count' => $lowStockCount,
            'pending_orders' => $pendingOrders,
            'recent_orders' => $recentOrders,
            'top_products' => $topProducts,
            'monthly_revenue' => $monthlyRevenue,
        ]);
    }

    // ---------------------------------------------------------------- Products

    public function products(Request $request): JsonResponse
    {
        $query = Product::with('category')->withCount('reviews');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock', '<', 5)->where('stock', '>', 0);
            } elseif ($request->stock === 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return response()->json($products);
    }

    public function showProduct(Product $product): JsonResponse
    {
        $product->load('category');

        return response()->json(['product' => $product]);
    }

    public function storeProduct(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|url|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = $this->uniqueSlug(Product::class, $validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $this->handleProductImages($request, $validated);

        $product = Product::create($validated);
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }

    public function updateProduct(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|url|max:2048',
            'is_featured' => 'nullable|boolean',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'nullable|string',
        ]);

        $validated['slug'] = $this->uniqueSlug(Product::class, $validated['name'], $product->id);
        $validated['is_featured'] = $request->boolean('is_featured');
        $this->handleProductImages($request, $validated, $product);

        $product->update($validated);
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'product' => $product,
        ]);
    }

    public function destroyProduct(Product $product): JsonResponse
    {
        $this->deleteStoredImage($product->image);
        foreach ($product->gallery_images as $image) {
            $this->deleteStoredImage($image);
        }

        $product->reviews()->delete();
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ]);
    }

    // ---------------------------------------------------------------- Categories

    public function categories(): JsonResponse
    {
        $categories = Category::with('parent', 'children')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $parents = Category::whereNull('parent_id')->orderBy('name')->get();

        return response()->json(['categories' => $categories, 'parents' => $parents]);
    }

    public function showCategory(Category $category): JsonResponse
    {
        $category->load('parent', 'children');
        $category->loadCount('products');

        return response()->json(['category' => $category]);
    }

    public function storeCategory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $validated['slug'] = $this->uniqueSlug(Category::class, $validated['name']);

        $category = Category::create($validated);
        $category->loadCount('products');

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'category' => $category,
        ], 201);
    }

    public function updateCategory(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $validated['slug'] = $this->uniqueSlug(Category::class, $validated['name'], $category->id);

        $category->update($validated);
        $category->loadCount('products');

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'category' => $category,
        ]);
    }

    public function destroyCategory(Category $category): JsonResponse
    {
        $category->products()->delete();
        $category->children()->update(['parent_id' => null]);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }

    // ---------------------------------------------------------------- Orders

    public function orders(Request $request): JsonResponse
    {
        $query = Order::with('user', 'items.product');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->q . '%')
                    ->orWhereHas('user', function ($uq) use ($request) {
                        $uq->where('name', 'like', '%' . $request->q . '%')
                            ->orWhere('email', 'like', '%' . $request->q . '%');
                    });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return response()->json($orders);
    }

    public function showOrder(Order $order): JsonResponse
    {
        $order->load('user', 'items.product');

        return response()->json(['order' => $order]);
    }

    public function updateOrderStatus(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update($validated);
        $order->load('user', 'items.product');

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'order' => $order,
        ]);
    }

    // ---------------------------------------------------------------- Inventory

    public function inventory(Request $request): JsonResponse
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->input('stock_status') === 'low') {
            $query->where('stock', '<', 5)->where('stock', '>', 0);
        } elseif ($request->input('stock_status') === 'out') {
            $query->where('stock', 0);
        } elseif ($request->input('stock_status') === 'in') {
            $query->where('stock', '>', 0);
        }

        $products = $query->orderBy('stock')->paginate(15)->withQueryString();

        $stats = [
            'total_products' => Product::count(),
            'total_stock' => (int) Product::sum('stock'),
            'low_stock' => Product::where('stock', '<', 5)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_value' => (float) Product::selectRaw('SUM(price * stock) as total')->value('total') ?? 0,
        ];

        return response()->json(['products' => $products, 'stats' => $stats]);
    }

    public function updateInventoryStock(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate(['stock' => 'required|integer|min:0']);

        $product->update(['stock' => $validated['stock']]);
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Stock updated for ' . $product->name,
            'product' => $product,
        ]);
    }

    // ---------------------------------------------------------------- Coupons

    public function coupons(Request $request): JsonResponse
    {
        $query = Coupon::query();

        if ($request->filled('q')) {
            $query->where('code', 'like', '%' . $request->q . '%');
        }

        $coupons = $query->latest()->paginate(15)->withQueryString();

        return response()->json($coupons);
    }

    public function storeCoupon(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $coupon = Coupon::create([
            ...$validated,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon created.',
            'coupon' => $coupon,
        ], 201);
    }

    public function toggleCoupon(Coupon $coupon): JsonResponse
    {
        $coupon->update(['is_active' => ! $coupon->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon ' . ($coupon->is_active ? 'activated' : 'deactivated') . '.',
            'is_active' => $coupon->is_active,
        ]);
    }

    public function destroyCoupon(Coupon $coupon): JsonResponse
    {
        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted.',
        ]);
    }

    // ---------------------------------------------------------------- Subscribers

    public function subscribers(Request $request): JsonResponse
    {
        $query = Subscriber::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->q . '%')
                    ->orWhere('name', 'like', '%' . $request->q . '%');
            });
        }

        $subscribers = $query->latest()->paginate(15)->withQueryString();

        return response()->json([
            'subscribers' => $subscribers,
            'total' => Subscriber::count(),
            'active' => Subscriber::where('is_active', true)->count(),
        ]);
    }

    public function toggleSubscriber(Subscriber $subscriber): JsonResponse
    {
        $subscriber->update(['is_active' => ! $subscriber->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Subscriber ' . ($subscriber->is_active ? 'activated' : 'deactivated') . '.',
            'is_active' => $subscriber->is_active,
        ]);
    }

    public function destroySubscriber(Subscriber $subscriber): JsonResponse
    {
        $subscriber->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscriber deleted.',
        ]);
    }

    // ---------------------------------------------------------------- Customers

    public function customers(Request $request): JsonResponse
    {
        $query = User::where('role', 'customer');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%')
                    ->orWhere('phone', 'like', '%' . $request->q . '%');
            });
        }

        $customers = $query->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return response()->json($customers);
    }

    public function destroyCustomer(User $customer): JsonResponse
    {
        if ($customer->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin accounts cannot be deleted.',
            ], 422);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted.',
        ]);
    }

    // ---------------------------------------------------------------- Reviews

    public function reviews(Request $request): JsonResponse
    {
        $query = Review::with('user', 'product');

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();

        return response()->json($reviews);
    }

    public function destroyReview(Review $review): JsonResponse
    {
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.',
        ]);
    }

    // ---------------------------------------------------------------- Reports

    public function salesReport(Request $request): JsonResponse
    {
        [$from, $to] = $this->parseRange($request);

        $totalRevenue = (float) Order::where('payment_status', 'paid')
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

        $topProducts = $this->topProducts($from, $to);

        return response()->json([
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'paid_orders' => $paidOrders,
            'avg_order_value' => $avgOrderValue,
            'daily_sales' => $dailySales,
            'top_products' => $topProducts,
        ]);
    }

    public function exportReportCsv(Request $request): StreamedResponse
    {
        [$from, $to] = $this->parseRange($request);

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

            fputcsv($handle, ['PulseTrade Sales Report']);
            fputcsv($handle, ['Period', $from->format('M d, Y') . ' — ' . $to->format('M d, Y')]);
            fputcsv($handle, []);

            $totalRevenue = $dailySales->sum('revenue');
            $totalOrders = $dailySales->sum('orders');
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            fputcsv($handle, ['Summary']);
            fputcsv($handle, ['Total Revenue', number_format($totalRevenue, 2)]);
            fputcsv($handle, ['Total Paid Orders', $totalOrders]);
            fputcsv($handle, ['Average Order Value', number_format($avgOrderValue, 2)]);
            fputcsv($handle, []);

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

    public function exportReportPdf(Request $request)
    {
        [$from, $to] = $this->parseRange($request);

        $totalRevenue = (float) Order::where('payment_status', 'paid')
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

        $topProducts = $this->topProducts($from, $to);

        $currencyCode = Setting::get('store_currency', 'USD');
        $symbols = [
            'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'JPY' => '¥', 'INR' => '₹', 'BDT' => '৳',
            'CAD' => 'C$', 'AUD' => 'A$', 'CNY' => '¥', 'BRL' => 'R$', 'KRW' => '₩',
            'MXN' => 'Mex$', 'SEK' => 'kr', 'NOK' => 'kr', 'DKK' => 'kr', 'CHF' => 'CHF',
            'PLN' => 'zł', 'CZK' => 'Kč', 'ZAR' => 'R', 'SGD' => 'S$', 'HKD' => 'HK$',
        ];
        $currencySymbol = $symbols[strtoupper($currencyCode)] ?? '$';

        $pdf = Pdf::loadView('admin.reports.sales-pdf', compact(
            'totalRevenue', 'totalOrders', 'paidOrders', 'avgOrderValue',
            'dailySales', 'topProducts', 'from', 'to', 'currencySymbol'
        ));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'sales-report-' . $from->format('Y-m-d') . '-to-' . $to->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    // ---------------------------------------------------------------- Settings

    public function settings(): JsonResponse
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        return response()->json(['settings' => $settings]);
    }

    public function updateSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            Setting::set($key, $value, $this->guessSettingGroup($key));
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated.',
        ]);
    }

    // ---------------------------------------------------------------- Report helpers

    private function parseRange(Request $request): array
    {
        $from = Carbon::parse($request->input('from', now()->subDays(30)->format('Y-m-d')))->startOfDay();
        $to = Carbon::parse($request->input('to', now()->format('Y-m-d')))->endOfDay();

        return [$from, $to];
    }

    private function topProducts(Carbon $from, Carbon $to)
    {
        return DB::table('order_items')
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
    }

    private function guessSettingGroup(string $key): string
    {
        $groups = [
            'store' => ['store_name', 'store_email', 'store_phone', 'store_address', 'store_currency'],
            'seo' => ['meta_title', 'meta_description'],
            'shipping' => ['free_shipping_threshold', 'shipping_cost'],
        ];

        foreach ($groups as $group => $keys) {
            if (in_array($key, $keys)) {
                return $group;
            }
        }

        return 'general';
    }

    // ---------------------------------------------------------------- Helpers

    private function uniqueSlug(string $model, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while ($model::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function handleProductImages(Request $request, array &$validated, ?Product $product = null): void
    {
        if ($product && $request->filled('remove_images')) {
            $current = $product->gallery_images;
            $removed = array_diff($current, $request->input('remove_images'));
            foreach ($removed as $path) {
                $this->deleteStoredImage($path);
            }
            $validated['images'] = array_values($removed);
        }

        if ($request->hasFile('image')) {
            if ($product && $this->isStoredImage($product->image)) {
                $this->deleteStoredImage($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            if ($product && $this->isStoredImage($product->image)) {
                $this->deleteStoredImage($product->image);
            }
            $validated['image'] = $request->input('image_url');
        }
        unset($validated['image_url']);

        $galleryPaths = $validated['images'] ?? ($product ? $product->gallery_images : []);

        if ($request->hasFile('images')) {
            if ($product && count($product->gallery_images) > 0 && ! $request->filled('remove_images')) {
                foreach ($product->gallery_images as $oldImage) {
                    $this->deleteStoredImage($oldImage);
                }
            }
            foreach ($request->file('images') as $image) {
                $galleryPaths[] = $image->store('products', 'public');
            }
        }

        if ($request->filled('gallery_urls')) {
            foreach ($request->input('gallery_urls') as $url) {
                if (! empty($url)) {
                    $galleryPaths[] = $url;
                }
            }
        }
        unset($validated['gallery_urls']);

        $validated['images'] = count($galleryPaths) > 0 ? array_values(array_unique($galleryPaths)) : null;
    }

    private function isStoredImage(?string $path): bool
    {
        return filled($path) && ! str_starts_with($path, 'http://') && ! str_starts_with($path, 'https://');
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($this->isStoredImage($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
