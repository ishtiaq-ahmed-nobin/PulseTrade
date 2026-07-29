<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CouponController as StorefrontCouponController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// --- Storefront ---
Route::get('/', function () {
    $featured = Product::where('is_featured', true)->with('category')->limit(6)->get();
    $bestSellers = Product::withCount('reviews')->with('category')->orderByDesc('reviews_count')->limit(4)->get();
    $newArrivals = Product::latest()->with('category')->limit(4)->get();
    $categories = Category::withCount('products')->get();

    return view('home', compact('featured', 'bestSellers', 'newArrivals', 'categories'));
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::get('/shop/product/{product:slug}', function (Product $product) {
    $product->load('category', 'reviews');
    $gallery = $product->gallery_urls;
    $reviews = $product->reviews()->with('user')->get();
    $related = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->with('category')
        ->limit(3)
        ->get();

    return view('shop.show', compact('product', 'gallery', 'reviews', 'related'));
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{productId}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

Route::post('/coupon/apply', [StorefrontCouponController::class, 'apply'])->name('coupon.apply');
Route::post('/coupon/remove', [StorefrontCouponController::class, 'remove'])->name('coupon.remove');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    return redirect()->route('contact')->with('success', 'Thanks for reaching out! We\'ll get back to you within 24 hours.');
});

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// --- Dashboard ---
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- Profile ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Admin Panel ---
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::resource('products', ProductController::class)->except(['show']);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');
    Route::get('reports/sales/csv', [SalesReportController::class, 'exportCsv'])->name('reports.sales.csv');
    Route::get('reports/sales/pdf', [SalesReportController::class, 'exportPdf'])->name('reports.sales.pdf');

    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::patch('inventory/{product}/stock', [InventoryController::class, 'updateStock'])->name('inventory.updateStock');

    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::patch('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])->name('coupons.toggle');
    Route::delete('coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');

    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::patch('subscribers/{subscriber}/toggle', [SubscriberController::class, 'toggle'])->name('subscribers.toggle');
    Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
