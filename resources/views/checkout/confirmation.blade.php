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

        <div class="mt-10 rounded-2xl border border-navy-100 p-6 text-left">
            <div class="flex justify-between text-sm">
                <span class="text-navy-700/60">Order Number</span>
                <span class="font-semibold text-navy-900">PT-{{ strtoupper(substr(md5(now()), 0, 8)) }}</span>
            </div>
            <div class="flex justify-between text-sm mt-3">
                <span class="text-navy-700/60">Estimated Delivery</span>
                <span class="font-semibold text-navy-900">{{ now()->addDays(3)->format('M j, Y') }}</span>
            </div>
            <div class="flex justify-between text-sm mt-3">
                <span class="text-navy-700/60">Total Paid</span>
                <span class="font-semibold text-navy-900">{{ $currency_symbol }}675.00</span>
            </div>
        </div>

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
