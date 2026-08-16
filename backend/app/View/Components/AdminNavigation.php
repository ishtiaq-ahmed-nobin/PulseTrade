<?php

namespace App\View\Components;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

class AdminNavigation
{
    public function __invoke(): array
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $lowStockCount = Product::where('stock', '<=', 5)->where('stock', '>', 0)->count();

        $navGroups = [
            [
                'slug'  => 'orders',
                'label' => 'Orders & Fulfillment',
                'badge' => $pendingOrders,
                'items' => [
                    [
                        'route' => 'admin.orders.index',
                        'label' => 'All Orders',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
                        'badge' => $pendingOrders,
                        'badge_color' => 'bg-red-500 text-white',
                    ],
                ],
            ],
            [
                'slug'  => 'inventory',
                'label' => 'Inventory & Stock',
                'badge' => $lowStockCount,
                'items' => [
                    [
                        'route' => 'admin.products.index',
                        'label' => 'All Products',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
                    ],
                    [
                        'route' => 'admin.inventory.index',
                        'label' => 'Stock & Inventory',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                        'badge' => $lowStockCount,
                        'badge_color' => 'bg-amber-500 text-white',
                    ],
                    [
                        'route' => 'admin.categories.index',
                        'label' => 'Categories',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>',
                    ],
                ],
            ],
            [
                'slug'  => 'reports',
                'label' => 'Analytics & Reports',
                'items' => [
                    [
                        'route' => 'admin.reports.sales',
                        'label' => 'Sales Report',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                    ],
                ],
            ],
            [
                'slug'  => 'marketing',
                'label' => 'Marketing & Promotions',
                'items' => [
                    [
                        'route' => 'admin.coupons.index',
                        'label' => 'Coupons',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>',
                    ],
                    [
                        'route' => 'admin.subscribers.index',
                        'label' => 'Subscribers',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    ],
                ],
            ],
            [
                'slug'  => 'users',
                'label' => 'User Management',
                'items' => [
                    [
                        'route' => 'admin.customers.index',
                        'label' => 'Customers',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    ],
                    [
                        'route' => 'admin.reviews.index',
                        'label' => 'Reviews',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                    ],
                ],
            ],
            [
                'slug'  => 'settings',
                'label' => 'System & Settings',
                'items' => [
                    [
                        'route' => 'admin.settings.index',
                        'label' => 'Store Settings',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    ],
                ],
            ],
        ];

        return $navGroups;
    }
}
