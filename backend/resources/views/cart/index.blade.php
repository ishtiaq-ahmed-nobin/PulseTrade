@php
    $fallbackImage = \App\Models\Product::fallbackImageUrl();
@endphp

<x-storefront-layout :title="'Your Cart — PulseTrade'" :cartCount="count($items)">

    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Step 1 of 2</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">Your Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[1fr_360px] gap-10">

        {{-- Cart items --}}
        <div>
            @if (count($items))
                <div class="divide-y divide-navy-100 border-y border-navy-100">
                    @foreach ($items as $item)
                        <div class="py-6 flex items-center gap-5">
                            <div class="w-24 h-24 rounded-xl bg-ivory overflow-hidden shrink-0">
                                <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover"
                                     onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-navy-900 text-sm">{{ $item['product']->name }}</p>
                                <p class="text-sm text-navy-700/50 mt-1">{{ $currency_symbol }}{{ number_format($item['product']->final_price, 2) }} each</p>
                                <form method="POST" action="{{ route('cart.destroy', $item['product']->id) }}" class="mt-3">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-600 font-medium">Remove</button>
                                </form>
                            </div>
                            <div class="flex items-center border border-navy-100 rounded-full shrink-0">
                                <form method="POST" action="{{ route('cart.update', $item['product']->id) }}" class="contents" x-data="{ qty: {{ $item['qty'] }} }">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="qty" :value="qty">
                                    <button type="button" @click="qty = Math.max(1, qty - 1); $el.closest('form').submit()" class="w-9 h-9 flex items-center justify-center text-navy-700 hover:text-pulse-500">−</button>
                                    <span class="w-8 text-center text-sm font-semibold">{{ $item['qty'] }}</span>
                                    <button type="button" @click="qty = qty + 1; $el.closest('form').submit()" class="w-9 h-9 flex items-center justify-center text-navy-700 hover:text-pulse-500">+</button>
                                </form>
                            </div>
                            <p class="w-20 text-right font-bold text-navy-900 text-sm shrink-0">{{ $currency_symbol }}{{ number_format($item['line_total'], 2) }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-pulse-500 hover:text-pulse-400 mt-6">
                    ← Continue Shopping
                </a>
            @else
                <div class="text-center py-20 border border-dashed border-navy-100 rounded-2xl">
                    <p class="font-display text-xl font-semibold text-navy-900">Your cart is empty</p>
                    <p class="text-sm text-navy-700/50 mt-2">Looks like you haven't added anything yet.</p>
                    <a href="{{ url('/shop') }}" class="inline-flex mt-6 px-6 py-3 rounded-full bg-navy-900 text-white text-sm font-semibold hover:bg-navy-800">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>

        {{-- Order summary --}}
        <div class="rounded-2xl border border-navy-100 p-6 h-fit sticky top-24">
            <h2 class="font-display font-semibold text-navy-900 mb-5">Order Summary</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between text-navy-700/70">
                    <span>Subtotal</span><span class="font-semibold text-navy-900">{{ $currency_symbol }}{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-navy-700/70">
                    <span>Shipping</span>
                    <span class="font-semibold {{ $shipping === 0 ? 'text-emerald-600' : 'text-navy-900' }}">
                        {{ $shipping === 0 ? 'Free' : $currency_symbol.number_format($shipping, 2) }}
                    </span>
                </div>
                @if ($shipping > 0 && count($items) > 0)
                    <p class="text-xs text-pulse-500 bg-pulse-100 rounded-lg px-3 py-2">
                        Add {{ $currency_symbol }}{{ number_format($freeShippingThreshold - $subtotal, 2) }} more for free shipping
                    </p>
                @endif
            </div>
            <div class="border-t border-navy-100 mt-4 pt-4 flex justify-between">
                <span class="font-semibold text-navy-900">Total</span>
                <span class="font-display font-bold text-lg text-navy-900">{{ $currency_symbol }}{{ number_format($total, 2) }}</span>
            </div>

            <div class="mt-5">
                <label class="text-xs font-semibold text-navy-700 mb-2 block">Promo code</label>
                <div class="flex gap-2">
                    <input type="text" placeholder="Enter code" class="flex-1 rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <button type="button" class="px-4 rounded-lg border border-navy-200 text-sm font-semibold text-navy-700 hover:border-pulse-500 hover:text-pulse-500">Apply</button>
                </div>
            </div>

            <a href="{{ url('/checkout') }}" class="mt-6 block text-center rounded-full bg-pulse-500 hover:bg-pulse-400 text-white font-semibold text-sm py-3.5 transition-colors">
                Proceed to Checkout
            </a>
            <div class="flex items-center justify-center gap-2 mt-4 text-xs text-navy-700/40">
                <span class="w-1.5 h-1.5 rounded-full bg-pulse-500"></span> Secure, encrypted checkout
            </div>
        </div>
    </div>
</x-storefront-layout>
