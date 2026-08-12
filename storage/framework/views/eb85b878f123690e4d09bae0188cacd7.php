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
        <h1 class="text-xl font-display font-bold text-navy-900">Orders</h1>
     <?php $__env->endSlot(); ?>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search order # or customer..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = ['pending', 'processing', 'shipped', 'completed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php echo e(request('status') === $status ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($status)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Payment</label>
                <select name="payment_status" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All</option>
                    <?php $__currentLoopData = ['pending', 'paid', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ps); ?>" <?php echo e(request('payment_status') === $ps ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($ps)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">
                Filter
            </button>
            <?php if(request()->hasAny(['q', 'status', 'payment_status'])): ?>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Order #</th>
                        <th class="px-5 py-3 font-medium">Customer</th>
                        <th class="px-5 py-3 font-medium">Items</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Payment</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Date</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    <?php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'completed' => 'bg-green-50 text-green-700 border-green-200',
                            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                        ];
                        $paymentColors = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'paid' => 'bg-green-50 text-green-700 border-green-200',
                            'failed' => 'bg-red-50 text-red-700 border-red-200',
                        ];
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3">
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="font-medium text-pulse-500 hover:text-pulse-400 font-mono text-xs">
                                    <?php echo e($order->order_number); ?>

                                </a>
                            </td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($order->user->name ?? 'N/A'); ?></td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($order->items->count()); ?></td>
                            <td class="px-5 py-3 font-medium"><?php echo e($currency_symbol); ?><?php echo e(number_format($order->total_amount, 2)); ?></td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border <?php echo e($paymentColors[$order->payment_status] ?? ''); ?>">
                                    <?php echo e(ucfirst($order->payment_status)); ?>

                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border <?php echo e($statusColors[$order->status] ?? ''); ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                            <td class="px-5 py-3 text-right">
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No orders found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($orders->hasPages()): ?>
            <div class="px-5 py-3 border-t border-navy-100">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>