@php
    $fallbackImage = \App\Models\Product::fallbackImageUrl();
    $activeSlug = request('category');
@endphp

<x-storefront-layout :title="$activeCategory ? $activeCategory->name . ' — PulseTrade' : 'Shop All Products — PulseTrade'">

    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Catalog</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">{{ $activeCategory ? $activeCategory->name : 'Shop All Products' }}</h1>
            <p class="text-ivory/60 mt-2 text-sm">{{ $products->count() }} {{ Str::plural('product', $products->count()) }}@if($activeCategory) in {{ $activeCategory->name }}@endif</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[240px_1fr] gap-10">

        {{-- Sidebar filters --}}
        <aside class="space-y-8">
            <div>
                <h3 class="font-display font-semibold text-sm text-navy-900 mb-4">Category</h3>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ url('/shop') }}" class="flex justify-between {{ is_null($activeSlug) ? 'text-pulse-500 font-semibold' : 'text-navy-700 hover:text-pulse-500 transition-colors' }}">
                            All Products <span>{{ $categories->sum('products_count') }}</span>
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ url('/shop?category='.$cat->slug) }}" class="flex justify-between {{ $activeSlug === $cat->slug ? 'text-pulse-500 font-semibold' : 'text-navy-700 hover:text-pulse-500 transition-colors' }}">
                                {{ $cat->name }} <span class="{{ $activeSlug === $cat->slug ? '' : 'text-navy-700/40' }}">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-display font-semibold text-sm text-navy-900 mb-4">Price Range</h3>
                <input type="range" min="0" max="1500" value="750" class="w-full accent-pulse-500">
                <div class="flex justify-between text-xs text-navy-700/50 mt-2">
                    <span>{{ $currency_symbol }}0</span><span>{{ $currency_symbol }}1,500+</span>
                </div>
            </div>

            <div>
                <h3 class="font-display font-semibold text-sm text-navy-900 mb-4">Availability</h3>
                <div class="space-y-2 text-sm text-navy-700">
                    <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-navy-100 text-pulse-500 focus:ring-pulse-500"> In Stock</label>
                    <label class="flex items-center gap-2"><input type="checkbox" class="rounded border-navy-100 text-pulse-500 focus:ring-pulse-500"> On Sale</label>
                </div>
            </div>
        </aside>

        {{-- Product grid --}}
        <div>
            <div class="flex items-center justify-between mb-6">
                <form action="{{ url('/shop') }}" method="GET" class="relative w-full max-w-xs">
                    @if($activeSlug)
                        <input type="hidden" name="category" value="{{ $activeSlug }}">
                    @endif
                    <input type="text" name="q" placeholder="Search products…"
                        class="w-full rounded-full border-navy-100 bg-ivory pl-4 pr-9 py-2.5 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </form>
                <select class="rounded-lg border-navy-100 text-sm text-navy-700 focus:border-pulse-500 focus:ring-pulse-500">
                    <option>Newest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>

            @if ($products->isEmpty())
                <div class="text-center py-20">
                    <p class="text-navy-700/50 text-sm">No products found{{ $activeCategory ? ' in ' . $activeCategory->name : '' }}.</p>
                    <a href="{{ url('/shop') }}" class="inline-block mt-4 text-sm font-semibold text-pulse-500 hover:text-pulse-400">Browse all products →</a>
                </div>
            @else
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ url('/shop/product/'.$product->slug) }}" class="group rounded-2xl border border-navy-100 bg-white overflow-hidden hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                            <div class="relative aspect-square bg-ivory overflow-hidden">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy"
                                     onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                                @if ($product->hasDiscount())
                                    <span class="absolute top-3 left-3 bg-white text-navy-900 text-[10px] font-bold px-2 py-1 rounded-full">SALE</span>
                                @endif
                                @if ($product->stock <= 0)
                                    <span class="absolute inset-0 bg-navy-950/60 flex items-center justify-center text-white text-xs font-semibold tracking-wide">OUT OF STOCK</span>
                                @elseif ($product->stock < 5)
                                    <span class="absolute top-3 right-3 bg-navy-950/80 text-white text-[10px] font-bold px-2 py-1 rounded-full">LOW STOCK</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-semibold text-navy-900 leading-snug group-hover:text-pulse-500 transition-colors">{{ $product->name }}</p>
                                <div class="mt-2 flex items-center gap-2">
                                    @if ($product->hasDiscount())
                                        <span class="text-sm font-bold text-pulse-500">{{ $currency_symbol }}{{ number_format($product->sale_price, 0) }}</span>
                                        <span class="text-xs text-navy-700/40 line-through">{{ $currency_symbol }}{{ number_format($product->price, 0) }}</span>
                                    @else
                                        <span class="text-sm font-bold text-navy-900">{{ $currency_symbol }}{{ number_format($product->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Pagination (static) --}}
            @if ($products->count() > 0)
                <div class="flex items-center justify-center gap-2 mt-12">
                    <span class="w-9 h-9 rounded-full bg-navy-900 text-white text-sm flex items-center justify-center font-semibold">1</span>
                    <span class="w-9 h-9 rounded-full text-navy-700 text-sm flex items-center justify-center hover:bg-ivory">2</span>
                    <span class="w-9 h-9 rounded-full text-navy-700 text-sm flex items-center justify-center hover:bg-ivory">3</span>
                    <span class="px-2 text-navy-700/40">…</span>
                </div>
            @endif
        </div>
    </div>
</x-storefront-layout>
