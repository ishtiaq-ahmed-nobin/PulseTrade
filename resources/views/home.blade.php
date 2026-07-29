@php
    $testimonials = [
        ['quote' => 'Packaging alone felt premium — the earbuds sound even better than the site promised.', 'name' => 'Marcus T.', 'role' => 'Verified Buyer'],
        ['quote' => 'Ordered the Zenith laptop on a Monday, was unboxing it by Wednesday. Zero hassle.', 'name' => 'Priya S.', 'role' => 'Verified Buyer'],
        ['quote' => 'Their support team swapped a faulty unit in two days, no questions asked.', 'name' => 'Daniel K.', 'role' => 'Verified Buyer'],
    ];
    $usps = [
        ['label' => 'Free Shipping', 'sub' => 'On orders over ' . $currency_symbol . '150'],
        ['label' => 'Secure Payment', 'sub' => 'Encrypted checkout'],
        ['label' => '2-Year Warranty', 'sub' => 'On every device'],
        ['label' => '24/7 Support', 'sub' => 'Real humans, fast replies'],
    ];
    $fallbackImage = \App\Models\Product::fallbackImageUrl();
@endphp

<x-storefront-layout :title="'PulseTrade — Electronics Built For The Everyday Edge'">

    {{-- 1. HERO BANNER --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <svg class="absolute inset-0 w-full h-full opacity-[0.15]" preserveAspectRatio="none" viewBox="0 0 1440 600">
            <path d="M0 300 H400 L440 120 L520 480 L600 300 H1440" fill="none" stroke="#5C7DFF" stroke-width="2"/>
        </svg>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-pulse-300 mb-6">
                    <span class="w-6 h-px bg-pulse-300"></span> New Season Drop
                </span>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.05] tracking-tight">
                    Tech that keeps pace<br class="hidden sm:block"> with your pulse.
                </h1>
                <p class="mt-6 text-lg text-ivory/70 max-w-md">
                    Curated audio, wearables, and computing gear — tested for performance, warrantied for peace of mind.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ url('/shop') }}" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-pulse-500 hover:bg-pulse-400 font-semibold text-sm transition-colors">
                        Shop the Collection
                    </a>
                    <a href="{{ url('/shop?category=audio') }}" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full border border-white/20 hover:border-white/40 font-semibold text-sm transition-colors">
                        Explore Audio
                    </a>
                </div>
            </div>
            <div class="relative aspect-square rounded-3xl bg-gradient-to-br from-pulse-500/30 to-navy-700/60 border border-white/10 flex items-center justify-center">
                <svg width="160" height="100" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#8FA4FF" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- 2. TRUST / USP STRIP --}}
    <section class="border-b border-navy-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($usps as $usp)
                <div class="flex items-start gap-3">
                    <span class="mt-1 w-2 h-2 rounded-full bg-pulse-500 shrink-0"></span>
                    <div>
                        <p class="font-semibold text-sm text-navy-900">{{ $usp['label'] }}</p>
                        <p class="text-xs text-navy-700/60 mt-0.5">{{ $usp['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 3. FEATURED CATEGORIES --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Browse</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Shop by Category</h2>
            </div>
            <a href="{{ url('/shop') }}" class="hidden sm:inline text-sm font-semibold text-pulse-500 hover:text-pulse-400">View all →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $cat)
                <a href="{{ url('/shop?category='.$cat->slug) }}" class="group rounded-2xl border border-navy-100 hover:border-pulse-300 p-5 text-center transition-colors">
                    <div class="mx-auto w-12 h-12 rounded-full bg-ivory flex items-center justify-center mb-3 group-hover:bg-pulse-100 transition-colors">
                        <span class="w-3 h-3 rounded-full bg-navy-800 group-hover:bg-pulse-500"></span>
                    </div>
                    <p class="text-sm font-semibold text-navy-900">{{ $cat->name }}</p>
                    <p class="text-xs text-navy-700/50 mt-0.5">{{ $cat->products_count }} items</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- 4. FEATURED PRODUCTS CAROUSEL --}}
    <section class="bg-ivory py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Handpicked</span>
                    <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Featured Products</h2>
                </div>
                <a href="{{ url('/shop') }}" class="hidden sm:inline text-sm font-semibold text-pulse-500 hover:text-pulse-400">View all →</a>
            </div>
            <div class="flex gap-5 overflow-x-auto pb-4 -mx-4 px-4 snap-x">
                @foreach ($featured as $product)
                    <x-product-card :product="$product" class="snap-start shrink-0 w-64" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. BEST SELLERS --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="mb-10">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Most Loved</span>
            <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Best Sellers</h2>
        </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($bestSellers as $i => $product)
                    <a href="{{ url('/shop/product/'.$product->slug) }}" class="relative rounded-2xl border border-navy-100 p-5 hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <span class="absolute top-4 right-4 text-xs font-bold text-navy-700/30">#{{ $i + 1 }}</span>
                        <div class="aspect-square rounded-xl overflow-hidden mb-4">
                            <img src="{{ $product->demo_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy"
                                 onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                        </div>
                        <p class="text-sm font-semibold text-navy-900">{{ $product->name }}</p>
                        <p class="text-xs text-navy-700/50 mt-1">{{ $product->reviews_count }} reviews</p>
                        <p class="text-sm font-bold text-navy-900 mt-2">{{ $currency_symbol }}{{ number_format($product->price, 0) }}</p>
                    </a>
                @endforeach
            </div>
    </section>

    {{-- 6. MID-PAGE PROMO BANNER --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="relative overflow-hidden rounded-3xl bg-navy-950 text-white px-8 py-16 sm:px-16 text-center">
            <svg class="absolute inset-0 w-full h-full opacity-10" preserveAspectRatio="none" viewBox="0 0 1440 300">
                <path d="M0 150 H500 L540 40 L600 260 H1440" fill="none" stroke="#8FA4FF" stroke-width="2"/>
            </svg>
            <div class="relative">
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Limited Time</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold mt-3">Up to 30% off selected gear</h2>
                <p class="mt-3 text-ivory/70">Ends when the stock runs out — not a day later.</p>
                <a href="{{ url('/shop?sale=1') }}" class="inline-flex mt-7 px-7 py-3.5 rounded-full bg-white text-navy-900 font-semibold text-sm hover:bg-pulse-100 transition-colors">
                    Shop the Sale
                </a>
            </div>
        </div>
    </section>

    {{-- 7. NEW ARRIVALS --}}
    <section class="bg-ivory py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Just Landed</span>
                    <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">New Arrivals</h2>
                </div>
                <a href="{{ url('/shop?sort=newest') }}" class="hidden sm:inline text-sm font-semibold text-pulse-500 hover:text-pulse-400">View all →</a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($newArrivals as $product)
                    <a href="{{ url('/shop/product/'.$product->slug) }}" class="rounded-2xl bg-white border border-navy-100 p-5 hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <div class="aspect-square rounded-xl overflow-hidden mb-4">
                            <img src="{{ $product->demo_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy"
                                 onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                        </div>
                        <span class="text-[10px] font-bold tracking-wider uppercase text-pulse-500">New</span>
                        <p class="text-sm font-semibold text-navy-900 mt-1">{{ $product->name }}</p>
                        <p class="text-sm font-bold text-navy-900 mt-2">{{ $currency_symbol }}{{ number_format($product->price, 0) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 8. DEAL OF THE DAY --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-10 items-center rounded-3xl border border-navy-100 p-8 sm:p-12">
            <div class="aspect-video lg:aspect-square rounded-2xl bg-gradient-to-br from-pulse-500 to-navy-800"></div>
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Deal of the Day</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Zenith 14" Ultrabook</h2>
                <p class="mt-3 text-navy-700/70">Featherweight magnesium chassis, all-day battery, and a display sharp enough for color-critical work.</p>
                <div class="mt-5 flex items-center gap-3">
                    <span class="text-2xl font-bold text-navy-900">{{ $currency_symbol }}1,299</span>
                    <span class="text-sm text-navy-700/40 line-through">{{ $currency_symbol }}1,499</span>
                    <span class="text-xs font-bold text-pulse-500 bg-pulse-100 px-2 py-1 rounded-full">Save 13%</span>
                </div>
                <div class="mt-6 flex gap-3">
                    @foreach (['14', '06', '48'] as $unit)
                        <div class="w-16 rounded-xl bg-ivory text-center py-3">
                            <p class="font-display font-bold text-lg text-navy-900">{{ $unit }}</p>
                            <p class="text-[10px] uppercase text-navy-700/50">{{ $loop->first ? 'hrs' : ($loop->iteration == 2 ? 'min' : 'sec') }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ url('/shop/product') }}" class="inline-flex mt-7 px-7 py-3.5 rounded-full bg-navy-900 text-white font-semibold text-sm hover:bg-navy-800 transition-colors">
                    Claim This Deal
                </a>
            </div>
        </div>
    </section>

    {{-- 9. WHY CHOOSE PULSETRADE --}}
    <section class="bg-navy-950 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Our Standard</span>
                <h2 class="font-display text-3xl font-bold mt-2">Why people choose PulseTrade</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([
                    ['title' => 'Curated Selection', 'body' => 'Every product is chosen, not just listed — we reject more gear than we stock.'],
                    ['title' => 'Verified Quality', 'body' => 'Bench-tested for build, battery, and performance before it reaches the catalog.'],
                    ['title' => 'Fast Delivery', 'body' => 'Most orders ship same-day and arrive within 48 hours.'],
                    ['title' => 'Expert Support', 'body' => 'Real specialists who know the difference between a driver and a DAC.'],
                ] as $point)
                    <div>
                        <div class="w-10 h-10 rounded-full border border-pulse-400/40 flex items-center justify-center mb-4">
                            <span class="w-2 h-2 rounded-full bg-pulse-400"></span>
                        </div>
                        <h3 class="font-display font-semibold text-lg">{{ $point['title'] }}</h3>
                        <p class="text-sm text-ivory/60 mt-2">{{ $point['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 10. CUSTOMER TESTIMONIALS --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Real Reviews</span>
            <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">What customers are saying</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($testimonials as $t)
                <div class="rounded-2xl bg-ivory p-7">
                    <div class="flex gap-0.5 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <span class="w-3.5 h-3.5 rounded-full bg-pulse-500"></span>
                        @endfor
                    </div>
                    <p class="text-sm text-navy-800 leading-relaxed">&ldquo;{{ $t['quote'] }}&rdquo;</p>
                    <p class="text-sm font-semibold text-navy-900 mt-5">{{ $t['name'] }}</p>
                    <p class="text-xs text-navy-700/50">{{ $t['role'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 11. BRAND / PARTNER STRIP --}}
    <section class="border-y border-navy-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-8">
            @foreach (['Voltix', 'Ampere Labs', 'Northwind Audio', 'Circuitry Co.', 'GridPoint'] as $brand)
                <span class="font-display font-semibold text-navy-900/30 text-lg tracking-tight">{{ $brand }}</span>
            @endforeach
        </div>
    </section>

    {{-- 12. NEWSLETTER SIGNUP --}}
    <section class="bg-navy-950 text-white py-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl font-bold">Get 10% off your first order</h2>
            <p class="mt-3 text-ivory/60">Product drops, restocks, and the occasional pulse-check on what's worth buying. No spam.</p>
            <form action="#" method="POST" class="mt-8 flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="you@email.com" required
                    class="flex-1 rounded-full border-0 bg-white/10 px-5 py-3.5 text-sm text-white placeholder:text-ivory/40 focus:ring-2 focus:ring-pulse-400">
                <button type="submit" class="rounded-full bg-pulse-500 hover:bg-pulse-400 px-6 py-3.5 text-sm font-semibold transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

</x-storefront-layout>
