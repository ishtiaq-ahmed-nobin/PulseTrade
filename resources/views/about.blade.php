@php
    $values = [
        ['title' => 'Curated, Not Crowded', 'body' => 'We reject more gear than we stock. Every product earns its place through rigorous evaluation — not ad spend or trend-chasing.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>'],
        ['title' => 'Radical Transparency', 'body' => 'Honest specs, honest pricing, honest reviews. We publish customer feedback unedited — the good and the constructive.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'],
        ['title' => 'People Over Algorithms', 'body' => "Real humans handle support, write copy, and pick products. You'll never talk to a bot — and you'll never wait days for a reply.", 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
        ['title' => 'Quality Guaranteed', 'body' => 'Every device ships with a 2-year warranty. If something goes wrong, we fix it or replace it — no runaround.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>'],
        ['title' => 'Sustainable Approach', 'body' => "We prioritize durability and repairability. Devices that last longer mean less waste — it's that simple.", 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
        ['title' => 'Fast & Free Shipping', 'body' => 'Orders over ' . $currency_symbol . '150 ship free, and most orders leave our warehouse the same day. Because waiting is the worst part.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>'],
    ];

    $stats = [
        ['number' => '15,000+', 'label' => 'Happy Customers'],
        ['number' => '200+', 'label' => 'Curated Products'],
        ['number' => '4.8', 'label' => 'Average Rating'],
        ['number' => '48hrs', 'label' => 'Avg. Delivery'],
    ];

    $team = [
        ['name' => 'James Walker', 'role' => 'Founder & CEO', 'gradient' => 'from-pulse-500 to-navy-700'],
        ['name' => 'Sarah Chen', 'role' => 'Head of Product', 'gradient' => 'from-navy-700 to-navy-950'],
        ['name' => 'Alex Rivera', 'role' => 'Lead Engineer', 'gradient' => 'from-pulse-400 to-pulse-500'],
        ['name' => 'Mia Thompson', 'role' => 'Customer Success', 'gradient' => 'from-navy-800 to-pulse-500'],
    ];
@endphp

<x-storefront-layout :title="'About Us — PulseTrade'">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <svg class="absolute inset-0 w-full h-full opacity-[0.12]" preserveAspectRatio="none" viewBox="0 0 1440 500">
            <path d="M0 250 H350 L390 80 L470 420 L550 250 H1440" fill="none" stroke="#5C7DFF" stroke-width="2"/>
        </svg>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
            <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-pulse-300 mb-6">
                <span class="w-6 h-px bg-pulse-300"></span> Our Story
            </span>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.05] tracking-tight max-w-3xl mx-auto">
                Built different.<br>Tested tougher.
            </h1>
            <p class="mt-6 text-lg text-ivory/60 max-w-xl mx-auto">
                PulseTrade was founded on a simple idea: electronics shopping should feel exciting, trustworthy, and refreshingly human.
            </p>
        </div>
    </section>

    {{-- Mission --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">What drives us</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Our Mission</h2>
                <p class="mt-5 text-navy-700/70 leading-relaxed">
                    We believe premium technology shouldn't come with premium guesswork. Every product in our catalog has been hand-selected, bench-tested, and evaluated by people who genuinely care about the gear they recommend.
                </p>
                <p class="mt-4 text-navy-700/70 leading-relaxed">
                    No filler listings. No misleading specs. Just electronics that deliver on their promise — backed by a team that picks up the phone when you call.
                </p>
            </div>
            <div class="relative">
                <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-pulse-500/20 to-navy-800/60 border border-navy-100 flex items-center justify-center">
                    <svg width="120" height="80" viewBox="0 0 34 24" class="pulse-line">
                        <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#8FA4FF" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-lg shadow-navy-900/5 border border-navy-100 px-6 py-4">
                    <p class="font-display font-bold text-2xl text-navy-900">7+</p>
                    <p class="text-xs text-navy-700/50">Years of curating tech</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="bg-ivory py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Our Principles</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">What we stand for</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($values as $val)
                    <div class="rounded-2xl bg-white border border-navy-100 p-7 hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <div class="w-11 h-11 rounded-full bg-pulse-50 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-pulse-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $val['icon'] !!}</svg>
                        </div>
                        <h3 class="font-display font-semibold text-lg text-navy-900">{{ $val['title'] }}</h3>
                        <p class="text-sm text-navy-700/60 mt-2 leading-relaxed">{{ $val['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-navy-950 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 text-center">
                @foreach ($stats as $stat)
                    <div>
                        <p class="font-display font-bold text-4xl text-white">{{ $stat['number'] }}</p>
                        <p class="text-sm text-ivory/50 mt-2">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">The People</span>
            <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Meet the team</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($team as $member)
                <div class="text-center">
                    <div class="w-28 h-28 rounded-full mx-auto bg-gradient-to-br {{ $member['gradient'] }} flex items-center justify-center mb-4">
                        <span class="font-display font-bold text-2xl text-white">{{ substr($member['name'], 0, 1) }}</span>
                    </div>
                    <p class="font-display font-semibold text-navy-900">{{ $member['name'] }}</p>
                    <p class="text-xs text-navy-700/50 mt-1">{{ $member['role'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-ivory py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl font-bold text-navy-900">Ready to explore?</h2>
            <p class="mt-3 text-navy-700/60">Browse our full catalog of hand-picked electronics — every item, tested and warrantied.</p>
            <a href="{{ url('/shop') }}" class="inline-flex mt-8 px-8 py-4 rounded-full bg-pulse-500 hover:bg-pulse-400 text-white font-semibold text-sm transition-colors">
                Shop the Collection
            </a>
        </div>
    </section>

</x-storefront-layout>
