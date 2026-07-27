<?php
    $cart = session('cart', []);
    $cartItems = [];
    $cartSubtotal = 0;
    $fallbackImage = \App\Models\Product::fallbackImageUrl();

    foreach ($cart as $productId => $qty) {
        $cartProduct = \App\Models\Product::find($productId);

        if ($cartProduct) {
            $lineTotal = $cartProduct->final_price * $qty;
            $cartSubtotal += $lineTotal;
            $cartItems[] = [
                'product' => $cartProduct,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }
    }

    $freeShippingThreshold = (float) \App\Models\Setting::get('free_shipping_threshold', 150);
    $shippingCost = (float) \App\Models\Setting::get('shipping_cost', 12);
    $cartShipping = ($cartSubtotal >= $freeShippingThreshold || count($cartItems) === 0) ? 0 : $shippingCost;
    $cartTotal = $cartSubtotal + $cartShipping;
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? 'PulseTrade — Premium Electronics'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

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
<body class="font-body antialiased bg-white text-navy-900" x-data="{ cartOpen: <?php echo e(session('open_cart') ? 'true' : 'false'); ?> }" @keydown.escape.window="cartOpen = false">

    <!-- Announcement bar -->
    <div class="bg-navy-950 text-ivory text-xs sm:text-sm text-center py-2 px-4 tracking-wide">
        Free shipping on orders over <?php echo e($currency_symbol); ?>150 &nbsp;•&nbsp; 2-year warranty on every device
    </div>

    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-navy-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-6">
            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2 shrink-0">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight text-navy-900">PulseTrade</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 font-medium text-sm text-navy-700">
                <a href="<?php echo e(url('/')); ?>" class="hover:text-pulse-500 transition-colors">Home</a>
                <a href="<?php echo e(url('/shop')); ?>" class="hover:text-pulse-500 transition-colors">Shop</a>
                <a href="<?php echo e(url('/blog')); ?>" class="hover:text-pulse-500 transition-colors">Blog</a>
                <a href="<?php echo e(url('/faq')); ?>" class="hover:text-pulse-500 transition-colors">FAQ</a>
                <a href="<?php echo e(url('/about')); ?>" class="hover:text-pulse-500 transition-colors">About</a>
                <a href="<?php echo e(url('/contact')); ?>" class="hover:text-pulse-500 transition-colors">Contact</a>
            </nav>

            <div class="flex items-center gap-4">
                <form action="<?php echo e(url('/shop')); ?>" method="GET" class="hidden lg:block relative">
                    <input type="text" name="q" placeholder="Search products…"
                        class="w-56 rounded-full border-navy-100 bg-ivory pl-4 pr-9 py-2 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/40">
                    <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-navy-700/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>

                <a href="<?php echo e(url('/account')); ?>" class="text-navy-700 hover:text-pulse-500 transition-colors" aria-label="Account">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <button type="button" @click="cartOpen = true" class="relative text-navy-700 hover:text-pulse-500 transition-colors" aria-label="Cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l3.6-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-pulse-500 text-white text-[10px] leading-none rounded-full w-4 h-4 flex items-center justify-center">
                        <?php echo e(array_sum(session('cart', [])) ?: 0); ?>

                    </span>
                </button>
            </div>
        </div>
    </header>

    <?php if(session('success')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="bg-emerald-50 border-b border-emerald-200 text-emerald-700 text-sm text-center py-3 px-4">
            <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="font-medium"><?php echo e(session('success')); ?></span>
                <button @click="show = false" class="ml-2 text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        </div>
    <?php endif; ?>

    <main>
        <?php echo e($slot); ?>

    </main>

    <div x-cloak x-show="cartOpen" class="fixed inset-0 z-50" aria-modal="true" role="dialog">
        <div x-show="cartOpen" x-transition.opacity class="absolute inset-0 bg-navy-950/50" @click="cartOpen = false"></div>

        <aside x-show="cartOpen"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="translate-x-full"
               class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">
            <div class="h-16 px-5 border-b border-navy-100 flex items-center justify-between">
                <div>
                    <h2 class="font-display font-semibold text-navy-900">Your Cart</h2>
                    <p class="text-xs text-navy-700/50"><?php echo e(array_sum($cart)); ?> items</p>
                </div>
                <button type="button" @click="cartOpen = false" class="w-9 h-9 rounded-full border border-navy-100 flex items-center justify-center text-navy-700 hover:text-pulse-500 hover:border-pulse-300" aria-label="Close cart">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5">
                <?php $__empty_1 = true; $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="py-5 border-b border-navy-100 flex gap-4">
                        <div class="w-20 h-20 rounded-lg bg-ivory overflow-hidden shrink-0">
                            <img src="<?php echo e($item['product']->image_url); ?>" alt="<?php echo e($item['product']->name); ?>" class="w-full h-full object-cover"
                                 onerror="this.onerror=null;this.src='<?php echo e($fallbackImage); ?>';">
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-navy-900 leading-snug"><?php echo e($item['product']->name); ?></p>
                            <p class="text-xs text-navy-700/50 mt-1"><?php echo e($currency_symbol); ?><?php echo e(number_format($item['product']->final_price, 2)); ?> each</p>
                            <div class="mt-3 flex items-center justify-between gap-3">
                                <form method="POST" action="<?php echo e(route('cart.update', $item['product']->id)); ?>" class="flex items-center border border-navy-100 rounded-full" x-data="{ qty: <?php echo e($item['qty']); ?> }">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <input type="hidden" name="qty" :value="qty">
                                    <button type="button" @click="qty = Math.max(1, qty - 1); $el.closest('form').submit()" class="w-8 h-8 flex items-center justify-center text-navy-700 hover:text-pulse-500">-</button>
                                    <span class="w-7 text-center text-xs font-semibold"><?php echo e($item['qty']); ?></span>
                                    <button type="button" @click="qty = qty + 1; $el.closest('form').submit()" class="w-8 h-8 flex items-center justify-center text-navy-700 hover:text-pulse-500">+</button>
                                </form>
                                <form method="POST" action="<?php echo e(route('cart.destroy', $item['product']->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-600">Remove</button>
                                </form>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-navy-900 shrink-0"><?php echo e($currency_symbol); ?><?php echo e(number_format($item['line_total'], 2)); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="h-full min-h-80 flex flex-col items-center justify-center text-center">
                        <p class="font-display text-xl font-semibold text-navy-900">Your cart is empty</p>
                        <p class="text-sm text-navy-700/50 mt-2">Add a product and it will appear here.</p>
                        <a href="<?php echo e(url('/shop')); ?>" @click="cartOpen = false" class="mt-6 px-5 py-2.5 rounded-full bg-navy-900 text-white text-sm font-semibold hover:bg-navy-800">Browse Products</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="border-t border-navy-100 p-5 space-y-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-navy-700/70">
                        <span>Subtotal</span>
                        <span class="font-semibold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($cartSubtotal, 2)); ?></span>
                    </div>
                    <div class="flex justify-between text-navy-700/70">
                        <span>Shipping</span>
                        <span class="font-semibold <?php echo e($cartShipping === 0 ? 'text-emerald-600' : 'text-navy-900'); ?>"><?php echo e($cartShipping === 0 ? 'Free' : $currency_symbol.number_format($cartShipping, 2)); ?></span>
                    </div>
                    <?php if($cartShipping > 0): ?>
                        <p class="text-xs text-pulse-500 bg-pulse-100 rounded-lg px-3 py-2">
                            Add <?php echo e($currency_symbol); ?><?php echo e(number_format($freeShippingThreshold - $cartSubtotal, 2)); ?> more for free shipping.
                        </p>
                    <?php endif; ?>
                </div>
                <div class="flex justify-between border-t border-navy-100 pt-4">
                    <span class="font-semibold text-navy-900">Total</span>
                    <span class="font-display font-bold text-lg text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($cartTotal, 2)); ?></span>
                </div>
                <a href="<?php echo e(url('/checkout')); ?>" class="block text-center rounded-full bg-pulse-500 hover:bg-pulse-400 text-white font-semibold text-sm py-3.5 transition-colors <?php echo e(count($cartItems) ? '' : 'pointer-events-none opacity-50'); ?>">
                    Checkout
                </a>
                <button type="button" @click="cartOpen = false" class="w-full text-center text-sm font-semibold text-pulse-500 hover:text-pulse-400">
                    Continue Shopping
                </button>
            </div>
        </aside>
    </div>

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
                    <li><a href="<?php echo e(url('/shop')); ?>" class="hover:text-pulse-300">All Products</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display text-sm font-semibold text-white mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-ivory/60">
                    <li><a href="<?php echo e(url('/faq')); ?>" class="hover:text-pulse-300">FAQ</a></li>
                    <li><a href="<?php echo e(url('/contact')); ?>" class="hover:text-pulse-300">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display text-sm font-semibold text-white mb-4">Company</h4>
                <ul class="space-y-2 text-sm text-ivory/60">
                    <li><a href="<?php echo e(url('/about')); ?>" class="hover:text-pulse-300">About</a></li>
                    <li><a href="<?php echo e(url('/blog')); ?>" class="hover:text-pulse-300">Blog</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-6 text-center text-xs text-ivory/40">
            © <?php echo e(date('Y')); ?> PulseTrade. All rights reserved.
        </div>
    </footer>
</body>
</html>
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/layouts/storefront.blade.php ENDPATH**/ ?>