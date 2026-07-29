@php
    // $product, $gallery, $reviews, $related are passed from the route
    $fallbackImage = \App\Models\Product::fallbackImageUrl();
@endphp

<x-storefront-layout :title="$product->name.' — PulseTrade'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-navy-700/50">
        <a href="{{ url('/') }}" class="hover:text-pulse-500">Home</a> /
        <a href="{{ url('/shop') }}" class="hover:text-pulse-500">Shop</a> /
        <a href="{{ url('/shop?category='.$product->category->slug) }}" class="hover:text-pulse-500">{{ $product->category->name }}</a> /
        <span class="text-navy-900">{{ $product->name }}</span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 grid lg:grid-cols-2 gap-12">

        {{-- Gallery --}}
        <div x-data="{ active: 0 }">
            <div class="relative aspect-square rounded-3xl overflow-hidden">
                @forelse ($gallery as $i => $url)
                    <img x-show="active === {{ $i }}" x-cloak src="{{ $url }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover"
                         onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                @empty
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover"
                             onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-navy-100 to-navy-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-navy-700/15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                @endforelse
            </div>
            @if (count($gallery) > 1)
                <div class="grid grid-cols-4 gap-3 mt-4">
                    @foreach ($gallery as $i => $url)
                        <button @click="active = {{ $i }}"
                            class="aspect-square rounded-xl overflow-hidden ring-2 transition-all"
                            :class="active === {{ $i }} ? 'ring-pulse-500' : 'ring-transparent opacity-70 hover:opacity-100'">
                            <img src="{{ $url }}" alt="Thumbnail {{ $i + 1 }}" class="w-full h-full object-cover"
                                 onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">{{ $product->category->name }}</span>
            <h1 class="font-display text-3xl font-bold text-navy-900 mt-2">{{ $product->name }}</h1>

            <div class="flex items-center gap-3 mt-3">
                @php $avg = $product->averageRating(); @endphp
                <div class="flex gap-0.5">
                    @for ($i = 0; $i < 5; $i++)
                        <span class="w-3.5 h-3.5 rounded-full {{ $i < floor($avg) ? 'bg-pulse-500' : 'bg-navy-100' }}"></span>
                    @endfor
                </div>
                <span class="text-sm text-navy-700/60">{{ number_format($avg, 1) }} ({{ $reviews->count() }} reviews)</span>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <span class="text-3xl font-bold text-navy-900">{{ $currency_symbol }}{{ number_format($product->final_price, 0) }}</span>
                @if ($product->hasDiscount())
                    <span class="text-lg text-navy-700/40 line-through">{{ $currency_symbol }}{{ number_format($product->price, 0) }}</span>
                    <span class="text-xs font-bold text-pulse-500 bg-pulse-100 px-2 py-1 rounded-full">Save {{ round((1 - $product->sale_price/$product->price)*100) }}%</span>
                @endif
            </div>

            <p class="mt-2 text-sm font-medium {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                {{ $product->stock > 0 ? '● In Stock — ready to ship' : '● Out of Stock' }}
            </p>

            <p class="mt-6 text-navy-700/70 leading-relaxed text-sm">{{ $product->description }}</p>

            <form action="{{ url('/cart') }}" method="POST" class="mt-8 flex items-center gap-4" x-data="{ qty: 1 }">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" :value="qty">
                <div class="flex items-center border border-navy-100 rounded-full">
                    <button type="button" @click="qty = Math.max(1, qty - 1)" class="w-10 h-10 flex items-center justify-center text-navy-700 hover:text-pulse-500">−</button>
                    <span class="w-8 text-center text-sm font-semibold" x-text="qty"></span>
                    <button type="button" @click="qty = qty + 1" class="w-10 h-10 flex items-center justify-center text-navy-700 hover:text-pulse-500">+</button>
                </div>
                <button type="submit" class="flex-1 rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3.5 transition-colors">
                    Add to Cart
                </button>
            </form>

            <div class="mt-8 grid grid-cols-2 gap-4 text-xs text-navy-700/60">
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pulse-500"></span> Free shipping over {{ $currency_symbol }}150</div>
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pulse-500"></span> 2-year warranty included</div>
            </div>
        </div>
    </div>

    {{-- Tabs: Description / Reviews --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20" x-data="{ tab: 'description' }">
        <div class="flex gap-8 border-b border-navy-100">
            <button @click="tab = 'description'" class="pb-4 text-sm font-semibold transition-colors"
                :class="tab === 'description' ? 'text-navy-900 border-b-2 border-pulse-500' : 'text-navy-700/50'">
                Description
            </button>
            <button @click="tab = 'reviews'" class="pb-4 text-sm font-semibold transition-colors"
                :class="tab === 'reviews' ? 'text-navy-900 border-b-2 border-pulse-500' : 'text-navy-700/50'">
                Reviews ({{ $reviews->count() }})
            </button>
        </div>

        <div x-show="tab === 'description'" class="py-8 max-w-3xl text-sm text-navy-700/70 leading-relaxed">
            {{ $product->description }}
        </div>

        <div x-show="tab === 'reviews'" x-cloak class="py-8 grid md:grid-cols-3 gap-6">
            @forelse ($reviews as $r)
                <div class="rounded-2xl bg-ivory p-6">
                    <div class="flex gap-0.5 mb-3">
                        @for ($i = 0; $i < 5; $i++)
                            <span class="w-3 h-3 rounded-full {{ $i < $r->rating ? 'bg-pulse-500' : 'bg-navy-100' }}"></span>
                        @endfor
                    </div>
                    <p class="text-sm text-navy-800 leading-relaxed">&ldquo;{{ $r->comment }}&rdquo;</p>
                    <p class="text-sm font-semibold text-navy-900 mt-4">{{ $r->user->name ?? 'Anonymous' }}</p>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-12 text-navy-700/40 text-sm">No reviews yet. Be the first to review this product.</div>
            @endforelse
        </div>
    </div>

    {{-- Related products --}}
    @if ($related->count())
    <div class="bg-ivory py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-navy-900 mb-8">You may also like</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </div>
    </div>
    @endif
</x-storefront-layout>
