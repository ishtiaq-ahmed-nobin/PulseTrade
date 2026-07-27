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
        <h1 class="text-xl font-display font-bold text-navy-900">Coupons</h1>
     <?php $__env->endSlot(); ?>

    <div class="bg-white rounded-xl border border-navy-100 p-5 mb-6" x-data="{ showForm: false }">
        <button @click="showForm = !showForm" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">
            <span x-text="showForm ? 'Cancel' : '+ New Coupon'"></span>
        </button>

        <div x-show="showForm" x-cloak x-transition class="mt-4">
            <form method="POST" action="<?php echo e(route('admin.coupons.store')); ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Code</label>
                    <input type="text" name="code" required placeholder="e.g. SAVE20"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Type</label>
                    <select name="type" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed (<?php echo e($currency_symbol); ?>)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Value</label>
                    <input type="number" name="value" required step="0.01" min="0" placeholder="20"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Min Order (<?php echo e($currency_symbol); ?>)</label>
                    <input type="number" name="min_order" step="0.01" min="0" placeholder="0"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Usage Limit</label>
                    <input type="number" name="usage_limit" min="1" placeholder="Unlimited"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Expires At</label>
                    <input type="datetime-local" name="expires_at"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <button type="submit" class="bg-pulse-500 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-pulse-400 transition-colors">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Code</th>
                        <th class="px-5 py-3 font-medium">Type</th>
                        <th class="px-5 py-3 font-medium">Value</th>
                        <th class="px-5 py-3 font-medium">Min Order</th>
                        <th class="px-5 py-3 font-medium">Used</th>
                        <th class="px-5 py-3 font-medium">Expires</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-mono font-medium text-navy-900"><?php echo e($coupon->code); ?></td>
                            <td class="px-5 py-3 text-navy-700 text-xs"><?php echo e($coupon->type === 'percentage' ? 'Percentage' : 'Fixed'); ?></td>
                            <td class="px-5 py-3 text-navy-900"><?php echo e($coupon->type === 'percentage' ? $coupon->value . '%' : $currency_symbol . number_format($coupon->value, 2)); ?></td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($coupon->min_order > 0 ? $currency_symbol . number_format($coupon->min_order, 2) : '—'); ?></td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($coupon->used_count); ?><?php echo e($coupon->usage_limit ? ' / ' . $coupon->usage_limit : ''); ?></td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs"><?php echo e($coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never'); ?></td>
                            <td class="px-5 py-3">
                                <?php if($coupon->isValid()): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">Active</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <form method="POST" action="<?php echo e(route('admin.coupons.toggle', $coupon)); ?>" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="text-amber-600 hover:text-amber-800 text-xs font-medium"><?php echo e($coupon->is_active ? 'Disable' : 'Enable'); ?></button>
                                </form>
                                <form method="POST" action="<?php echo e(route('admin.coupons.destroy', $coupon)); ?>" class="inline" onsubmit="return confirm('Delete this coupon?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-navy-700/40">No coupons yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($coupons->hasPages()): ?>
            <div class="px-5 py-3 border-t border-navy-100"><?php echo e($coupons->links()); ?></div>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views\admin\coupons\index.blade.php ENDPATH**/ ?>