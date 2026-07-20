<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PulseTrade — Premium Electronics' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes pulse-travel {
            0%   { stroke-dashoffset: 240; }
            100% { stroke-dashoffset: 0; }
        }
        .pulse-line path {
            stroke-dasharray: 240;
            animation: pulse-travel 3.2s linear infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            .pulse-line path { animation: none; }
        }
    </style>
</head>
<body class="font-body antialiased bg-white text-navy-900">

    <!-- Announcement bar -->
    <div class="bg-navy-950 text-ivory text-xs sm:text-sm text-center py-2 px-4 tracking-wide">
        Free shipping on orders over {{ $currency_symbol }}150 &nbsp;•&nbsp; 2-year warranty on every device
    </div>

    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-navy-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight text-navy-900">PulseTrade</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 font-medium text-sm text-navy-700">
                <a href="{{ url('/') }}" class="hover:text-pulse-500 transition-colors">Home</a>
                <a href="{{ url('/shop') }}" class="hover:text-pulse-500 transition-colors">Shop</a>
                <a href="{{ url('/blog') }}" class="hover:text-pulse-500 transition-colors">Blog</a>
                <a href="{{ url('/faq') }}" class="hover:text-pulse-500 transition-colors">FAQ</a>
                <a href="{{ url('/about') }}" class="hover:text-pulse-500 transition-colors">About</a>
                <a href="{{ url('/contact') }}" class="hover:text-pulse-500 transition-colors">Contact</a>
            </nav>

            <div class="flex items-center gap-4">
                <form action="{{ url('/shop') }}" method="GET" class="hidden lg:block relative">
                    <input type="text" name="q" placeholder="Search products…"
                        class="w-56 rounded-full border-navy-100 bg-ivory pl-4 pr-9 py-2 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/40">
                    <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-navy-700/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>

                <a href="{{ url('/account') }}" class="text-navy-700 hover:text-pulse-500 transition-colors" aria-label="Account">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <a href="{{ url('/cart') }}" class="relative text-navy-700 hover:text-pulse-500 transition-colors" aria-label="Cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l3.6-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-pulse-500 text-white text-[10px] leading-none rounded-full w-4 h-4 flex items-center justify-center">
                        {{ count(session('cart', [])) ?: 0 }}
                    </span>
                </a>
            </div>
        </div>
    </header>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="bg-emerald-50 border-b border-emerald-200 text-emerald-700 text-sm text-center py-3 px-4">
            <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-2 text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-navy-950 text-ivory mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-2 md:grid-cols-5 gap-10">
            <div class="col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <svg width="30" height="20" viewBox="0 0 34 24" class="pulse-line">
                        <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#8FA4FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="font-display font-bold text-lg text-white">PulseTrade</span>
                </div>
                <p class="text-sm text-ivory/60 max-w-xs">Premium electronics, curated for people who notice the details. Every device, tested and warrantied.</p>
            </div>
            <div>
                <h4 class="font-display text-sm font-semibold text-white mb-4">Shop</h4>
                <ul class="space-y-2 text-sm text-ivory/60">
                    <li><a href="{{ url('/shop') }}" class="hover:text-pulse-300">All Products</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display text-sm font-semibold text-white mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-ivory/60">
                    <li><a href="{{ url('/faq') }}" class="hover:text-pulse-300">FAQ</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-pulse-300">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display text-sm font-semibold text-white mb-4">Company</h4>
                <ul class="space-y-2 text-sm text-ivory/60">
                    <li><a href="{{ url('/about') }}" class="hover:text-pulse-300">About</a></li>
                    <li><a href="{{ url('/blog') }}" class="hover:text-pulse-300">Blog</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-6 text-center text-xs text-ivory/40">
            © {{ date('Y') }} PulseTrade. All rights reserved.
        </div>
    </footer>
</body>
</html>
