<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'Order Confirmed — PulseTrade','cartCount' => 0] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <div class="w-16 h-16 rounded-full bg-pulse-100 flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-pulse-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Order Confirmed</span>
        <h1 class="font-display text-3xl font-bold text-navy-900 mt-3">Thank you — it's on the way.</h1>
        <p class="text-navy-700/60 mt-3">A confirmation email with tracking details will follow shortly.</p>

        <?php if($order): ?>
            <div class="mt-10 rounded-2xl border border-navy-100 p-6 text-left">
                <div class="flex justify-between text-sm">
                    <span class="text-navy-700/60">Order Number</span>
                    <span class="font-semibold text-navy-900"><?php echo e($order->order_number); ?></span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Status</span>
                    <span class="font-semibold text-navy-900 capitalize"><?php echo e($order->status); ?></span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Payment</span>
                    <span class="font-semibold text-navy-900 capitalize"><?php echo e(str_replace('_', ' ', $order->payment_method)); ?> — <?php echo e($order->payment_status); ?></span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Shipping To</span>
                    <span class="font-semibold text-navy-900"><?php echo e($order->shipping_address); ?></span>
                </div>
                <?php if($order->coupon_code && $order->discount_amount > 0): ?>
                    <div class="flex justify-between text-sm mt-3">
                        <span class="text-navy-700/60">Coupon</span>
                        <span class="font-semibold text-emerald-600"><?php echo e($order->coupon_code); ?></span>
                    </div>
                    <div class="flex justify-between text-sm mt-3">
                        <span class="text-navy-700/60">Discount</span>
                        <span class="font-semibold text-emerald-600">-<?php echo e($currency_symbol); ?><?php echo e(number_format($order->discount_amount, 2)); ?></span>
                    </div>
                <?php endif; ?>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Estimated Delivery</span>
                    <span class="font-semibold text-navy-900"><?php echo e(now()->addDays(3)->format('M j, Y')); ?></span>
                </div>
                <div class="flex justify-between text-sm mt-3">
                    <span class="text-navy-700/60">Total Paid</span>
                    <span class="font-semibold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($order->total_amount, 2)); ?></span>
                </div>

                <?php if($order->items->count()): ?>
                    <div class="border-t border-navy-100 mt-4 pt-4">
                        <p class="text-xs font-semibold text-navy-700/60 uppercase tracking-wide mb-3">Items</p>
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-navy-700/70"><?php echo e($item->product->name ?? 'Product'); ?> × <?php echo e($item->quantity); ?></span>
                                <span class="font-semibold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($item->price * $item->quantity, 2)); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="<?php echo e(url('/shop')); ?>" class="px-7 py-3.5 rounded-full bg-navy-900 text-white font-semibold text-sm hover:bg-navy-800 transition-colors">
                Continue Shopping
            </a>
            <a href="<?php echo e(url('/')); ?>" class="px-7 py-3.5 rounded-full border border-navy-100 text-navy-700 font-semibold text-sm hover:border-pulse-500 hover:text-pulse-500 transition-colors">
                Back to Home
            </a>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/checkout/confirmation.blade.php ENDPATH**/ ?>