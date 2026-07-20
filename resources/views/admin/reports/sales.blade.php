<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Sales Report</h1>
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
                            <tr><td colspan="3" class="px-5 py-8 text-center text-navy-700/40">No sales in this period.</td></tr>
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
                            <tr><td colspan="3" class="px-5 py-8 text-center text-navy-700/40">No product data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
