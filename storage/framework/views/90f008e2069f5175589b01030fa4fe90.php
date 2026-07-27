<?php
    $items = [
        ['name' => 'Aeon Pro Wireless Headphones', 'price' => 279, 'qty' => 1],
        ['name' => 'Halo Noise-Cancel Earbuds', 'price' => 159, 'qty' => 2],
        ['name' => 'Flux Fast-Charge Power Bank', 'price' => 79, 'qty' => 1],
    ];
    $subtotal = array_sum(array_map(fn ($i) => $i['price'] * $i['qty'], $items));
    $shipping = $subtotal >= 150 ? 0 : 12;
    $total = $subtotal + $shipping;
?>

<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'Checkout — PulseTrade','cartCount' => 3] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Step 2 of 2</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">Checkout</h1>
        </div>
    </div>

    <form action="<?php echo e(url('/checkout')); ?>" method="POST"
          class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[1fr_380px] gap-10"
          x-data="{ payment: 'card', processing: false }"
          @submit.prevent="processing = true; setTimeout(() => { window.location.href = '<?php echo e(url('/checkout/confirmation')); ?>' }, 1400)">

        <div class="space-y-10">
            
            <div>
                <h2 class="font-display font-semibold text-lg text-navy-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-navy-900 text-white text-xs flex items-center justify-center">1</span>
                    Shipping Details
                </h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Full Name</label>
                        <input type="text" required placeholder="Jordan Rivera" class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Shipping Address</label>
                        <input type="text" required placeholder="221B Circuit Lane" class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">City</label>
                        <input type="text" required class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Postal Code</label>
                        <input type="text" required class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Phone</label>
                        <input type="tel" required placeholder="+1 (555) 000-0000" class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                </div>
            </div>

            
            <div>
                <h2 class="font-display font-semibold text-lg text-navy-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-navy-900 text-white text-xs flex items-center justify-center">2</span>
                    Payment Method
                </h2>

                <div class="grid sm:grid-cols-2 gap-4 mb-6">
                    <button type="button" @click="payment = 'card'"
                        class="rounded-xl border p-4 text-left transition-colors"
                        :class="payment === 'card' ? 'border-pulse-500 bg-pulse-100/50' : 'border-navy-100'">
                        <p class="font-semibold text-sm text-navy-900">Credit / Debit Card</p>
                        <p class="text-xs text-navy-700/50 mt-1">Simulated card payment</p>
                    </button>
                    <button type="button" @click="payment = 'cod'"
                        class="rounded-xl border p-4 text-left transition-colors"
                        :class="payment === 'cod' ? 'border-pulse-500 bg-pulse-100/50' : 'border-navy-100'">
                        <p class="font-semibold text-sm text-navy-900">Cash on Delivery</p>
                        <p class="text-xs text-navy-700/50 mt-1">Pay when it arrives</p>
                    </button>
                </div>

                <div x-show="payment === 'card'" x-cloak class="rounded-xl border border-navy-100 p-5 space-y-4 bg-ivory">
                    <div>
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Card Number</label>
                        <input type="text" placeholder="4242 4242 4242 4242" maxlength="19" class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Expiry</label>
                            <input type="text" placeholder="MM / YY" class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-navy-700 mb-1.5 block">CVC</label>
                            <input type="text" placeholder="123" class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        </div>
                    </div>
                    <p class="text-[11px] text-navy-700/40">This is a simulated checkout — no real charge will be made.</p>
                </div>

                <div x-show="payment === 'cod'" x-cloak class="rounded-xl border border-navy-100 p-5 bg-ivory text-sm text-navy-700/70">
                    Pay in cash when your order is delivered. A team member will confirm by phone before dispatch.
                </div>
            </div>
        </div>

        
        <div class="rounded-2xl border border-navy-100 p-6 h-fit sticky top-24">
            <h2 class="font-display font-semibold text-navy-900 mb-5">Order Summary</h2>
            <div class="space-y-3 mb-4">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-navy-700/70"><?php echo e($item['name']); ?> × <?php echo e($item['qty']); ?></span>
                        <span class="font-semibold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($item['price'] * $item['qty'], 2)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="border-t border-navy-100 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-navy-700/70"><span>Subtotal</span><span><?php echo e($currency_symbol); ?><?php echo e(number_format($subtotal, 2)); ?></span></div>
                <div class="flex justify-between text-navy-700/70"><span>Shipping</span><span><?php echo e($shipping === 0 ? 'Free' : $currency_symbol.number_format($shipping, 2)); ?></span></div>
            </div>
            <div class="border-t border-navy-100 mt-4 pt-4 flex justify-between">
                <span class="font-semibold text-navy-900">Total</span>
                <span class="font-display font-bold text-lg text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($total, 2)); ?></span>
            </div>

            <button type="submit" :disabled="processing"
                class="mt-6 w-full rounded-full bg-pulse-500 hover:bg-pulse-400 disabled:opacity-70 text-white font-semibold text-sm py-3.5 transition-colors flex items-center justify-center gap-2">
                <svg x-show="processing" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span x-text="processing ? 'Processing…' : 'Place Order'"></span>
            </button>
            <p class="text-center text-[11px] text-navy-700/40 mt-4">By placing your order you agree to our Terms &amp; Return Policy.</p>
        </div>
    </form>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views\checkout\index.blade.php ENDPATH**/ ?>