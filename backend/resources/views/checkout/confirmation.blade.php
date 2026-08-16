<x-storefront-layout :title="'Order Confirmed — PulseTrade'" :cartCount="0">

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <div class="w-16 h-16 rounded-full bg-pulse-100 flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-pulse-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Order Confirmed</span>
        <h1 class="font-display text-3xl font-bold text-navy-900 mt-3">Thank you — it's on the way.</h1>
        <p class="text-navy-700/60 mt-3">A confirmation email with tracking details will follow shortly.</p>

        @if ($order)
            <div class="mt-10 rounded-2xl border border-navy-100 p-6 text-left">
                <div class="flex justify-between text-sm">
                    <span class="text-navy-700/60">Order Number</span>
                    <span class="font-semibold text-navy-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Status</span>
                    <span class="font-semibold text-navy-900 capitalize">{{ $order->status }}</span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Payment</span>
                    <span class="font-semibold text-navy-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }} — {{ $order->payment_status }}</span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Shipping To</span>
                    <span class="font-semibold text-navy-900">{{ $order->shipping_address }}</span>
                </div>
                @if ($order->coupon_code && $order->discount_amount > 0)
                    <div class="flex justify-between text-sm mt-3">
                        <span class="text-navy-700/60">Coupon</span>
                        <span class="font-semibold text-emerald-600">{{ $order->coupon_code }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-3">
                        <span class="text-navy-700/60">Discount</span>
                        <span class="font-semibold text-emerald-600">-{{ $currency_symbol }}{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Estimated Delivery</span>
                    <span class="font-semibold text-navy-900">{{ now()->addDays(3)->format('M j, Y') }}</span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Total Paid</span>
                    <span class="font-semibold text-navy-900">{{ $currency_symbol }}{{ number_format($order->total_amount, 2) }}</span>
                </div>

                @if ($order->items->count())
                    <div class="border-t border-navy-100 mt-4 pt-4">
                        <p class="text-xs font-semibold text-navy-700/60 uppercase tracking-wide mb-3">Items</p>
                        @foreach ($order->items as $item)
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-navy-700/70">{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }}</span>
                                <span class="font-semibold text-navy-900">{{ $currency_symbol }}{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/shop') }}" class="px-7 py-3.5 rounded-full bg-navy-900 text-white font-semibold text-sm hover:bg-navy-800 transition-colors">
                Continue Shopping
            </a>
            <a href="{{ url('/') }}" class="px-7 py-3.5 rounded-full border border-navy-100 text-navy-700 font-semibold text-sm hover:border-pulse-500 hover:text-pulse-500 transition-colors">
                Back to Home
            </a>
        </div>
    </div>
</x-storefront-layout>
