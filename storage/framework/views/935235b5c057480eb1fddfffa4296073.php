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
        <h1 class="text-xl font-display font-bold text-navy-900">Dashboard</h1>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Revenue -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Total Revenue</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($currency_symbol); ?><?php echo e(number_format($totalRevenue, 2)); ?></p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Total Orders</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($totalOrders); ?></p>
                        <p class="text-xs text-amber-600 mt-1"><?php echo e($pendingOrders); ?> pending</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Total Products</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($totalProducts); ?></p>
                        <?php if($lowStockCount > 0): ?>
                            <p class="text-xs text-red-600 mt-1"><?php echo e($lowStockCount); ?> low stock</p>
                        <?php endif; ?>
                    </div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-navy-700/60">Customers</p>
                        <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($totalUsers); ?></p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-navy-100">
                <div class="px-5 py-4 border-b border-navy-100 flex items-center justify-between">
                    <h2 class="font-display font-semibold text-navy-900">Recent Orders</h2>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-pulse-500 hover:text-pulse-400 font-medium">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-navy-700/60 border-b border-navy-100">
                                <th class="px-5 py-3 font-medium">Order</th>
                                <th class="px-5 py-3 font-medium">Customer</th>
                                <th class="px-5 py-3 font-medium">Total</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-navy-50">
                            <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-ivory/50 transition-colors">
                                    <td class="px-5 py-3">
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="font-medium text-pulse-500 hover:text-pulse-400">
                                            <?php echo e($order->order_number); ?>

                                        </a>
                                    </td>
                                    <td class="px-5 py-3 text-navy-700"><?php echo e($order->user->name ?? 'N/A'); ?></td>
                                    <td class="px-5 py-3 font-medium"><?php echo e($currency_symbol); ?><?php echo e(number_format($order->total_amount, 2)); ?></td>
                                    <td class="px-5 py-3">
                                        <?php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'completed' => 'bg-green-50 text-green-700 border-green-200',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                            ];
                                        ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border <?php echo e($statusColors[$order->status] ?? ''); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-navy-700/40">No orders yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-xl border border-navy-100">
                <div class="px-5 py-4 border-b border-navy-100">
                    <h2 class="font-display font-semibold text-navy-900">Top Products</h2>
                </div>
                <div class="divide-y divide-navy-50">
                    <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-5 py-3 flex items-center gap-3">
                            <div class="w-10 h-10 bg-ivory rounded-lg overflow-hidden shrink-0">
                                <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover"
                                     onerror="this.onerror=null;this.src='<?php echo e(\App\Models\Product::fallbackImageUrl()); ?>';">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-navy-900 truncate"><?php echo e($product->name); ?></p>
                                <p class="text-xs text-navy-700/50"><?php echo e($product->reviews_count); ?> reviews · <?php echo e(round($product->reviews_sum_rating / max($product->reviews_count, 1), 1)); ?>★</p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-5 py-8 text-center text-navy-700/40 text-sm">No products yet.</div>
                    <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>