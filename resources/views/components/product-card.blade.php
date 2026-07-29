@props(['product'])

<a href="{{ url('/shop/product/'.$product->slug) }}" {{ $attributes->merge(['class' => 'group rounded-2xl border border-navy-100 bg-white overflow-hidden hover:shadow-lg hover:shadow-navy-900/5 transition-shadow']) }}>
    <div class="relative aspect-square bg-ivory overflow-hidden">
        <img src="{{ $product->demo_image_url }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy"
             onerror="this.onerror=null;this.src='{{ \App\Models\Product::fallbackImageUrl() }}';">
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
                <span class="text-sm font-bold text-pulse-500">{{ $currency_symbol ?? '$' }}{{ number_format($product->sale_price, 0) }}</span>
                <span class="text-xs text-navy-700/40 line-through">{{ $currency_symbol ?? '$' }}{{ number_format($product->price, 0) }}</span>
            @else
                <span class="text-sm font-bold text-navy-900">{{ $currency_symbol ?? '$' }}{{ number_format($product->price, 0) }}</span>
            @endif
        </div>
    </div>
</a>
