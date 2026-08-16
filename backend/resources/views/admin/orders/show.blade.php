<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="text-navy-700/60 hover:text-navy-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-display font-bold text-navy-900">Order {{ $order->order_number }}</h1>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-xl border border-navy-100">
                <div class="px-5 py-4 border-b border-navy-100">
                    <h2 class="font-display font-semibold text-navy-900">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-navy-700/60 border-b border-navy-100">
                                <th class="px-5 py-3 font-medium">Product</th>
                                <th class="px-5 py-3 font-medium">Price</th>
                                <th class="px-5 py-3 font-medium">Qty</th>
                                <th class="px-5 py-3 font-medium text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-navy-50">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($item->product?->image)
                                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-ivory shrink-0">
                                                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover"
                                                         onerror="this.onerror=null;this.src='{{ \App\Models\Product::fallbackImageUrl() }}';">
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-navy-900">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-navy-700">{{ $currency_symbol }}{{ number_format($item->price, 2) }}</td>
                                    <td class="px-5 py-3 text-navy-700">{{ $item->quantity }}</td>
                                    <td class="px-5 py-3 text-right font-medium">{{ $currency_symbol }}{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @php
                                $subtotal = $order->items->sum(fn ($item) => $item->price * $item->quantity);
                            @endphp
                            <tr class="border-t border-navy-100">
                                <td colspan="3" class="px-5 py-2 text-right text-sm text-navy-700/60">Subtotal</td>
                                <td class="px-5 py-2 text-right text-sm text-navy-700">{{ $currency_symbol }}{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            @if ($order->coupon_code && $order->discount_amount > 0)
                                <tr>
                                    <td colspan="3" class="px-5 py-2 text-right text-sm text-emerald-600">
                                        Discount <span class="font-medium">({{ $order->coupon_code }})</span>
                                    </td>
                                    <td class="px-5 py-2 text-right text-sm font-medium text-emerald-600">-{{ $currency_symbol }}{{ number_format($order->discount_amount, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="border-t border-navy-100">
                                <td colspan="3" class="px-5 py-3 text-right font-medium text-navy-700">Total</td>
                                <td class="px-5 py-3 text-right font-bold text-navy-900">{{ $currency_symbol }}{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Update Form -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Order Status</label>
                        <select name="status"
                                class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Payment Status</label>
                        <select name="payment_status"
                                class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            @foreach (['pending', 'paid', 'failed'] as $ps)
                                <option value="{{ $ps }}" {{ $order->payment_status === $ps ? 'selected' : '' }}>
                                    {{ ucfirst($ps) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-pulse-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Customer</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-navy-700"><span class="text-navy-700/60">Name:</span> {{ $order->user->name ?? 'N/A' }}</p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Phone:</span> {{ $order->shipping_phone }}</p>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Shipping</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-navy-700">{{ $order->shipping_address }}</p>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Payment</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-navy-700"><span class="text-navy-700/60">Method:</span> {{ strtoupper($order->payment_method) }}</p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Status:</span>
                        @php
                            $paymentColors = [
                                'pending' => 'bg-amber-50 text-amber-700',
                                'paid' => 'bg-green-50 text-green-700',
                                'failed' => 'bg-red-50 text-red-700',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$order->payment_status] ?? '' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Date:</span> {{ $order->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>

            <!-- Coupon Info -->
            @if ($order->coupon_code && $order->discount_amount > 0)
                <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-5">
                    <h3 class="font-display font-semibold text-emerald-800 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                        Coupon Applied
                    </h3>
                    <div class="space-y-2 text-sm">
                        <p class="text-emerald-700"><span class="text-emerald-600/60">Code:</span> <span class="font-semibold">{{ $order->coupon_code }}</span></p>
                        <p class="text-emerald-700"><span class="text-emerald-600/60">Discount:</span> <span class="font-semibold">-{{ $currency_symbol }}{{ number_format($order->discount_amount, 2) }}</span></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
