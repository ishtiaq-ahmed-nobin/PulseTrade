<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Dashboard</h1>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Revenue -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Total Revenue</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $currency_symbol }}{{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Total Orders</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $totalOrders }}</p>
                        <p class="text-xs text-amber-600 mt-1">{{ $pendingOrders }} pending</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Total Products</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $totalProducts }}</p>
                        @if($lowStockCount > 0)
                            <p class="text-xs text-red-600 mt-1">{{ $lowStockCount }} low stock</p>
                        @endif
                    </div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Customers</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-navy-100">
                <div class="px-5 py-4 border-b border-navy-100 flex items-center justify-between">
                    <h2 class="font-display font-semibold text-navy-900">Recent Orders</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-pulse-500 hover:text-pulse-400 font-medium">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-navy-700/60 border-b border-navy-100">
                                <th class="px-5 py-3 font-medium">Order</th>
                                <th class="px-5 py-3 font-medium">Customer</th>
                                <th class="px-5 py-3 font-medium">Total</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-navy-50">
                            @forelse ($recentOrders as $order)
                                <tr class="hover:bg-ivory/50 transition-colors">
                                    <td class="px-5 py-3">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-pulse-500 hover:text-pulse-400">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3 text-navy-700">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-5 py-3 font-medium">{{ $currency_symbol }}{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-5 py-3">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'completed' => 'bg-green-50 text-green-700 border-green-200',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$order->status] ?? '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-navy-700/40">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-xl border border-navy-100">
                <div class="px-5 py-4 border-b border-navy-100">
                    <h2 class="font-display font-semibold text-navy-900">Top Products</h2>
                </div>
                <div class="divide-y divide-navy-50">
                    @forelse ($topProducts as $product)
                        <div class="px-5 py-3 flex items-center gap-3">
                            <div class="w-10 h-10 bg-ivory rounded-lg overflow-hidden shrink-0">
                                @if($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-navy-700/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-navy-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-navy-700/50">{{ $product->reviews_count }} reviews · {{ round($product->reviews_sum_rating / max($product->reviews_count, 1), 1) }}★</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center text-navy-700/40 text-sm">No products yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
