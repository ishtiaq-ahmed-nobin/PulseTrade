<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-display font-bold text-navy-900">Sales Report</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.reports.sales.csv', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 bg-white border border-navy-200 text-navy-700 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-navy-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </a>
                <a href="{{ route('admin.reports.sales.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 bg-white border border-navy-200 text-navy-700 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-navy-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-navy-700/60 mb-1">From</label>
                <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-navy-700/60 mb-1">To</label>
                <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">Generate</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Revenue</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $currency_symbol }}{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Orders</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Paid Orders</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $paidOrders }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Avg Order Value</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $currency_symbol }}{{ number_format($avgOrderValue, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-navy-100">
            <div class="px-5 py-4 border-b border-navy-100">
                <h2 class="font-display font-semibold text-navy-900">Daily Sales</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-navy-700/60 border-b border-navy-100">
                            <th class="px-5 py-3 font-medium">Date</th>
                            <th class="px-5 py-3 font-medium">Orders</th>
                            <th class="px-5 py-3 font-medium">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        @forelse ($dailySales as $day)
                            <tr class="hover:bg-ivory/50 transition-colors">
                                <td class="px-5 py-3 text-navy-900">{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                <td class="px-5 py-3 text-navy-700">{{ $day->orders }}</td>
                                <td class="px-5 py-3 font-medium">{{ $currency_symbol }}{{ number_format($day->revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-navy-700/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        <p class="text-navy-700/40 text-sm font-medium">No sales in this period</p>
                                        <p class="text-navy-700/30 text-xs mt-1">Try adjusting the date range above.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-navy-100">
            <div class="px-5 py-4 border-b border-navy-100">
                <h2 class="font-display font-semibold text-navy-900">Top Products</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-navy-700/60 border-b border-navy-100">
                            <th class="px-5 py-3 font-medium">Product</th>
                            <th class="px-5 py-3 font-medium">Qty Sold</th>
                            <th class="px-5 py-3 font-medium">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        @forelse ($topProducts as $product)
                            <tr class="hover:bg-ivory/50 transition-colors">
                                <td class="px-5 py-3 font-medium text-navy-900">{{ $product->name }}</td>
                                <td class="px-5 py-3 text-navy-700">{{ $product->qty_sold }}</td>
                                <td class="px-5 py-3 font-medium">{{ $currency_symbol }}{{ number_format($product->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-navy-700/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p class="text-navy-700/40 text-sm font-medium">No product data</p>
                                        <p class="text-navy-700/30 text-xs mt-1">No paid orders with products in this period.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
