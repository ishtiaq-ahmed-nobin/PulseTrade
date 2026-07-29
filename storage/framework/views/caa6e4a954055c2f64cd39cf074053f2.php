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
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-display font-bold text-navy-900">Sales Report</h1>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.reports.sales.csv', request()->query())); ?>"
                   class="inline-flex items-center gap-1.5 bg-white border border-navy-200 text-navy-700 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-navy-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </a>
                <a href="<?php echo e(route('admin.reports.sales.pdf', request()->query())); ?>"
                   class="inline-flex items-center gap-1.5 bg-white border border-navy-200 text-navy-700 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-navy-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export PDF
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.reports.sales')); ?>" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-navy-700/60 mb-1">From</label>
                <input type="date" name="from" value="<?php echo e($from->format('Y-m-d')); ?>" class="rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-navy-700/60 mb-1">To</label>
                <input type="date" name="to" value="<?php echo e($to->format('Y-m-d')); ?>" class="rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">Generate</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Revenue</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($currency_symbol); ?><?php echo e(number_format($totalRevenue, 2)); ?></p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Orders</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($totalOrders); ?></p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Paid Orders</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($paidOrders); ?></p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Avg Order Value</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($currency_symbol); ?><?php echo e(number_format($avgOrderValue, 2)); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-navy-100">
            <div class="px-5 py-4 border-b border-navy-100">
                <h2 class="font-display font-semibold text-navy-900">Daily Sales</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-navy-700/60 border-b border-navy-100">
                            <th class="px-5 py-3 font-medium">Date</th>
                            <th class="px-5 py-3 font-medium">Orders</th>
                            <th class="px-5 py-3 font-medium">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        <?php $__empty_1 = true; $__currentLoopData = $dailySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-ivory/50 transition-colors">
                                <td class="px-5 py-3 text-navy-900"><?php echo e(\Carbon\Carbon::parse($day->date)->format('M d, Y')); ?></td>
                                <td class="px-5 py-3 text-navy-700"><?php echo e($day->orders); ?></td>
                                <td class="px-5 py-3 font-medium"><?php echo e($currency_symbol); ?><?php echo e(number_format($day->revenue, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-navy-700/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        <p class="text-navy-700/40 text-sm font-medium">No sales in this period</p>
                                        <p class="text-navy-700/30 text-xs mt-1">Try adjusting the date range above.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-navy-100">
            <div class="px-5 py-4 border-b border-navy-100">
                <h2 class="font-display font-semibold text-navy-900">Top Products</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-navy-700/60 border-b border-navy-100">
                            <th class="px-5 py-3 font-medium">Product</th>
                            <th class="px-5 py-3 font-medium">Qty Sold</th>
                            <th class="px-5 py-3 font-medium">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-ivory/50 transition-colors">
                                <td class="px-5 py-3 font-medium text-navy-900"><?php echo e($product->name); ?></td>
                                <td class="px-5 py-3 text-navy-700"><?php echo e($product->qty_sold); ?></td>
                                <td class="px-5 py-3 font-medium"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->total_revenue, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-navy-700/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p class="text-navy-700/40 text-sm font-medium">No product data</p>
                                        <p class="text-navy-700/30 text-xs mt-1">No paid orders with products in this period.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views\admin\reports\sales.blade.php ENDPATH**/ ?>