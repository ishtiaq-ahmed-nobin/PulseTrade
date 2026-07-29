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
        <h1 class="text-xl font-display font-bold text-navy-900">Inventory</h1>
     <?php $__env->endSlot(); ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Products</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($totalProducts); ?></p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Stock</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1"><?php echo e($totalStock); ?></p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Low Stock (&lt;5)</p>
            <p class="text-2xl font-display font-bold text-amber-600 mt-1"><?php echo e($lowStock); ?></p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Out of Stock</p>
            <p class="text-2xl font-display font-bold text-red-600 mt-1"><?php echo e($outOfStock); ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.inventory.index')); ?>" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search products..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Stock Status</label>
                <select name="stock_status" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All</option>
                    <option value="in" <?php echo e(request('stock_status') === 'in' ? 'selected' : ''); ?>>In Stock</option>
                    <option value="low" <?php echo e(request('stock_status') === 'low' ? 'selected' : ''); ?>>Low Stock</option>
                    <option value="out" <?php echo e(request('stock_status') === 'out' ? 'selected' : ''); ?>>Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Product</th>
                        <th class="px-5 py-3 font-medium">Category</th>
                        <th class="px-5 py-3 font-medium">Price</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Value</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-navy-900"><?php echo e($product->name); ?></td>
                            <td class="px-5 py-3 text-navy-700 text-xs"><?php echo e($product->category->name ?? '—'); ?></td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price, 2)); ?></td>
                            <td class="px-5 py-3">
                                <?php if($product->stock === 0): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Out of Stock</span>
                                <?php elseif($product->stock < 5): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200"><?php echo e($product->stock); ?> units</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200"><?php echo e($product->stock); ?> units</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price * $product->stock, 2)); ?></td>
                            <td class="px-5 py-3 text-right">
                                <div x-data="{ editing: false }">
                                    <button x-show="!editing" @click="editing = true" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Update</button>
                                    <form x-show="editing" x-cloak method="POST" action="<?php echo e(route('admin.inventory.updateStock', $product)); ?>" class="inline-flex items-center gap-1">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input type="number" name="stock" value="<?php echo e($product->stock); ?>" min="0" class="w-16 rounded border-navy-200 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-xs font-medium">Save</button>
                                        <button type="button" @click="editing = false" class="text-navy-700/40 hover:text-navy-900 text-xs">Cancel</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($products->hasPages()): ?>
            <div class="px-5 py-3 border-t border-navy-100"><?php echo e($products->links()); ?></div>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views\admin\inventory\index.blade.php ENDPATH**/ ?>