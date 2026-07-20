<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Orders</h1>
    </x-slot>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search order # or customer..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All Statuses</option>
                    @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Payment</label>
                <select name="payment_status" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All</option>
                    @foreach (['pending', 'paid', 'failed'] as $ps)
                        <option value="{{ $ps }}" {{ request('payment_status') === $ps ? 'selected' : '' }}>
                            {{ ucfirst($ps) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['q', 'status', 'payment_status']))
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Clear</a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Order #</th>
                        <th class="px-5 py-3 font-medium">Customer</th>
                        <th class="px-5 py-3 font-medium">Items</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Payment</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Date</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'completed' => 'bg-green-50 text-green-700 border-green-200',
                            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                        ];
                        $paymentColors = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'paid' => 'bg-green-50 text-green-700 border-green-200',
                            'failed' => 'bg-red-50 text-red-700 border-red-200',
                        ];
                    @endphp
                    @forelse ($orders as $order)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-pulse-500 hover:text-pulse-400 font-mono text-xs">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-navy-700">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $order->items->count() }}</td>
                            <td class="px-5 py-3 font-medium">{{ $currency_symbol }}{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $paymentColors[$order->payment_status] ?? '' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$order->status] ?? '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
