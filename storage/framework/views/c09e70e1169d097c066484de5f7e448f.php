<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'Your Cart — PulseTrade','cartCount' => count($items)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Step 1 of 2</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">Your Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[1fr_360px] gap-10">

        
        <div>
            <?php if(count($items)): ?>
                <div class="divide-y divide-navy-100 border-y border-navy-100">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="py-6 flex items-center gap-5">
                            <div class="w-24 h-24 rounded-xl bg-ivory overflow-hidden shrink-0">
                                <?php if($item['product']->image_url): ?>
                                    <img src="<?php echo e($item['product']->image_url); ?>" alt="<?php echo e($item['product']->name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-navy-100 to-navy-200">
                                        <svg class="w-8 h-8 text-navy-700/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-navy-900 text-sm"><?php echo e($item['product']->name); ?></p>
                                <p class="text-sm text-navy-700/50 mt-1"><?php echo e($currency_symbol); ?><?php echo e(number_format($item['product']->final_price, 2)); ?> each</p>
                                <form method="POST" action="<?php echo e(route('cart.destroy', $item['product']->id)); ?>" class="mt-3">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-600 font-medium">Remove</button>
                                </form>
                            </div>
                            <div class="flex items-center border border-navy-100 rounded-full shrink-0">
                                <form method="POST" action="<?php echo e(route('cart.update', $item['product']->id)); ?>" class="contents" x-data="{ qty: <?php echo e($item['qty']); ?> }">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <input type="hidden" name="qty" :value="qty">
                                    <button type="button" @click="qty = Math.max(1, qty - 1); $el.closest('form').submit()" class="w-9 h-9 flex items-center justify-center text-navy-700 hover:text-pulse-500">−</button>
                                    <span class="w-8 text-center text-sm font-semibold"><?php echo e($item['qty']); ?></span>
                                    <button type="button" @click="qty = qty + 1; $el.closest('form').submit()" class="w-9 h-9 flex items-center justify-center text-navy-700 hover:text-pulse-500">+</button>
                                </form>
                            </div>
                            <p class="w-20 text-right font-bold text-navy-900 text-sm shrink-0"><?php echo e($currency_symbol); ?><?php echo e(number_format($item['line_total'], 2)); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a href="<?php echo e(url('/shop')); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-pulse-500 hover:text-pulse-400 mt-6">
                    ← Continue Shopping
                </a>
            <?php else: ?>
                <div class="text-center py-20 border border-dashed border-navy-100 rounded-2xl">
                    <p class="font-display text-xl font-semibold text-navy-900">Your cart is empty</p>
                    <p class="text-sm text-navy-700/50 mt-2">Looks like you haven't added anything yet.</p>
                    <a href="<?php echo e(url('/shop')); ?>" class="inline-flex mt-6 px-6 py-3 rounded-full bg-navy-900 text-white text-sm font-semibold hover:bg-navy-800">
                        Browse Products
                    </a>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="rounded-2xl border border-navy-100 p-6 h-fit sticky top-24">
            <h2 class="font-display font-semibold text-navy-900 mb-5">Order Summary</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between text-navy-700/70">
                    <span>Subtotal</span><span class="font-semibold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($subtotal, 2)); ?></span>
                </div>
                <div class="flex justify-between text-navy-700/70">
                    <span>Shipping</span>
                    <span class="font-semibold <?php echo e($shipping === 0 ? 'text-emerald-600' : 'text-navy-900'); ?>">
                        <?php echo e($shipping === 0 ? 'Free' : $currency_symbol.number_format($shipping, 2)); ?>

                    </span>
                </div>
                <?php if($shipping > 0 && count($items) > 0): ?>
                    <p class="text-xs text-pulse-500 bg-pulse-100 rounded-lg px-3 py-2">
                        Add <?php echo e($currency_symbol); ?><?php echo e(number_format($freeShippingThreshold - $subtotal, 2)); ?> more for free shipping
                    </p>
                <?php endif; ?>
            </div>
            <div class="border-t border-navy-100 mt-4 pt-4 flex justify-between">
                <span class="font-semibold text-navy-900">Total</span>
                <span class="font-display font-bold text-lg text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($total, 2)); ?></span>
            </div>

            <div class="mt-5">
                <label class="text-xs font-semibold text-navy-700 mb-2 block">Promo code</label>
                <div class="flex gap-2">
                    <input type="text" placeholder="Enter code" class="flex-1 rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <button type="button" class="px-4 rounded-lg border border-navy-200 text-sm font-semibold text-navy-700 hover:border-pulse-500 hover:text-pulse-500">Apply</button>
                </div>
            </div>

            <a href="<?php echo e(url('/checkout')); ?>" class="mt-6 block text-center rounded-full bg-pulse-500 hover:bg-pulse-400 text-white font-semibold text-sm py-3.5 transition-colors">
                Proceed to Checkout
            </a>
            <div class="flex items-center justify-center gap-2 mt-4 text-xs text-navy-700/40">
                <span class="w-1.5 h-1.5 rounded-full bg-pulse-500"></span> Secure, encrypted checkout
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462)): ?>
<?php $attributes = $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462; ?>
<?php unset($__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462)): ?>
<?php $component = $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462; ?>
<?php unset($__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views/cart/index.blade.php ENDPATH**/ ?>