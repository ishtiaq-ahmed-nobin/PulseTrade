<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-navy-700/60 hover:text-navy-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-display font-bold text-navy-900">Order <?php echo e($order->order_number); ?></h1>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-xl border border-navy-100">
                <div class="px-5 py-4 border-b border-navy-100">
                    <h2 class="font-display font-semibold text-navy-900">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-navy-700/60 border-b border-navy-100">
                                <th class="px-5 py-3 font-medium">Product</th>
                                <th class="px-5 py-3 font-medium">Price</th>
                                <th class="px-5 py-3 font-medium">Qty</th>
                                <th class="px-5 py-3 font-medium text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-navy-50">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <?php if($item->product?->image): ?>
                                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-ivory shrink-0">
                                                    <img src="<?php echo e($item->product->image_url); ?>" class="w-full h-full object-cover"
                                                         onerror="this.onerror=null;this.src='<?php echo e(\App\Models\Product::fallbackImageUrl()); ?>';">
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-medium text-navy-900"><?php echo e($item->product->name ?? 'Deleted Product'); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-navy-700"><?php echo e($currency_symbol); ?><?php echo e(number_format($item->price, 2)); ?></td>
                                    <td class="px-5 py-3 text-navy-700"><?php echo e($item->quantity); ?></td>
                                    <td class="px-5 py-3 text-right font-medium"><?php echo e($currency_symbol); ?><?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-navy-100">
                                <td colspan="3" class="px-5 py-3 text-right font-medium text-navy-700">Total</td>
                                <td class="px-5 py-3 text-right font-bold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($order->total_amount, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Update Form -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Update Status</h3>
                <form method="POST" action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Order Status</label>
                        <select name="status"
                                class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            <?php $__currentLoopData = ['pending', 'processing', 'shipped', 'completed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e($order->status === $status ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($status)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Payment Status</label>
                        <select name="payment_status"
                                class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            <?php $__currentLoopData = ['pending', 'paid', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ps); ?>" <?php echo e($order->payment_status === $ps ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($ps)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-pulse-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Customer</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-navy-700"><span class="text-navy-700/60">Name:</span> <?php echo e($order->user->name ?? 'N/A'); ?></p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Email:</span> <?php echo e($order->user->email ?? 'N/A'); ?></p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Phone:</span> <?php echo e($order->shipping_phone); ?></p>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Shipping</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-navy-700"><?php echo e($order->shipping_address); ?></p>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h3 class="font-display font-semibold text-navy-900 mb-4">Payment</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-navy-700"><span class="text-navy-700/60">Method:</span> <?php echo e(strtoupper($order->payment_method)); ?></p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Status:</span>
                        <?php
                            $paymentColors = [
                                'pending' => 'bg-amber-50 text-amber-700',
                                'paid' => 'bg-green-50 text-green-700',
                                'failed' => 'bg-red-50 text-red-700',
                            ];
                        ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($paymentColors[$order->payment_status] ?? ''); ?>">
                            <?php echo e(ucfirst($order->payment_status)); ?>

                        </span>
                    </p>
                    <p class="text-navy-700"><span class="text-navy-700/60">Date:</span> <?php echo e($order->created_at->format('M d, Y g:i A')); ?></p>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>