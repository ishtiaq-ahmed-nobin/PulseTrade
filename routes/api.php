<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are consumed by the React SPA (frontend/). Auth is cookie /
| session based so the SPA can run on the same origin (or via the Vite proxy
| during local development) without CORS headaches.
|
*/

Route::prefix('v1')->group(function () {
    // --- Public: settings / store info ---
    Route::get('/settings/public', [SettingController::class, 'public']);

    // --- Public: storefront catalog ---
    Route::get('/home', [ProductController::class, 'home']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product:slug}', [ProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);

    // --- Auth (cookie session) ---
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/auth/user', [AuthController::class, 'user'])->middleware('auth');

    // --- Checkout (guest checkout supported; a user account is created if needed) ---
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::post('/coupon/validate', [CouponController::class, 'validate']);

    // --- Authenticated customer actions ---
    Route::middleware('auth')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::patch('/profile', [AuthController::class, 'updateProfile']);
        Route::patch('/password', [AuthController::class, 'updatePassword']);

        Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
    });

    // --- Admin panel ---
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);

        Route::get('/products', [AdminController::class, 'products']);
        Route::post('/products', [AdminController::class, 'storeProduct']);
        Route::get('/products/{product}', [AdminController::class, 'showProduct']);
        Route::put('/products/{product}', [AdminController::class, 'updateProduct']);
        Route::delete('/products/{product}', [AdminController::class, 'destroyProduct']);

        Route::get('/categories', [AdminController::class, 'categories']);
        Route::post('/categories', [AdminController::class, 'storeCategory']);
        Route::get('/categories/{category}', [AdminController::class, 'showCategory']);
        Route::put('/categories/{category}', [AdminController::class, 'updateCategory']);
        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory']);

        Route::get('/orders', [AdminController::class, 'orders']);
        Route::get('/orders/{order}', [AdminController::class, 'showOrder']);
        Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus']);

        Route::get('/inventory', [AdminController::class, 'inventory']);
        Route::patch('/inventory/{product}/stock', [AdminController::class, 'updateInventoryStock']);

        Route::get('/coupons', [AdminController::class, 'coupons']);
        Route::post('/coupons', [AdminController::class, 'storeCoupon']);
        Route::patch('/coupons/{coupon}/toggle', [AdminController::class, 'toggleCoupon']);
        Route::delete('/coupons/{coupon}', [AdminController::class, 'destroyCoupon']);

        Route::get('/subscribers', [AdminController::class, 'subscribers']);
        Route::patch('/subscribers/{subscriber}/toggle', [AdminController::class, 'toggleSubscriber']);
        Route::delete('/subscribers/{subscriber}', [AdminController::class, 'destroySubscriber']);

        Route::get('/customers', [AdminController::class, 'customers']);
        Route::delete('/customers/{customer}', [AdminController::class, 'destroyCustomer']);

        Route::get('/reviews', [AdminController::class, 'reviews']);
        Route::delete('/reviews/{review}', [AdminController::class, 'destroyReview']);

        Route::get('/reports/sales', [AdminController::class, 'salesReport']);
        Route::get('/reports/sales/csv', [AdminController::class, 'exportReportCsv']);
        Route::get('/reports/sales/pdf', [AdminController::class, 'exportReportPdf']);

        Route::get('/settings', [AdminController::class, 'settings']);
        Route::patch('/settings', [AdminController::class, 'updateSettings']);
    });
});
