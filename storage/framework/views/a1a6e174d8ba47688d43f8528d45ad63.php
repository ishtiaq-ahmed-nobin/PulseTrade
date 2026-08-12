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
            <h1 class="text-xl font-display font-bold text-navy-900">Products</h1>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="inline-flex items-center gap-2 bg-pulse-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Product
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search products..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div class="min-w-[160px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Category</label>
                <select name="category" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Stock</label>
                <select name="stock" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All</option>
                    <option value="low" <?php echo e(request('stock') === 'low' ? 'selected' : ''); ?>>Low Stock (&lt;5)</option>
                    <option value="out" <?php echo e(request('stock') === 'out' ? 'selected' : ''); ?>>Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">
                Filter
            </button>
            <?php if(request()->hasAny(['q', 'category', 'stock'])): ?>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Product</th>
                        <th class="px-5 py-3 font-medium">Category</th>
                        <th class="px-5 py-3 font-medium">Price</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Featured</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-ivory rounded-lg overflow-hidden shrink-0">
                                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover"
                                             onerror="this.onerror=null;this.src='<?php echo e(\App\Models\Product::fallbackImageUrl()); ?>';">
                                    </div>
                                    <div>
                                        <p class="font-medium text-navy-900"><?php echo e($product->name); ?></p>
                                        <p class="text-xs text-navy-700/50 font-mono"><?php echo e($product->slug); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-navy-700"><?php echo e($product->category->name ?? 'N/A'); ?></td>
                            <td class="px-5 py-3">
                                <?php if($product->hasDiscount()): ?>
                                    <span class="text-navy-700/40 line-through text-xs"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price, 2)); ?></span>
                                    <span class="text-red-600 font-medium ml-1"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->sale_price, 2)); ?></span>
                                <?php else: ?>
                                    <span class="font-medium"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price, 2)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3">
                                <?php if($product->stock === 0): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Out of Stock</span>
                                <?php elseif($product->stock < 5): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200"><?php echo e($product->stock); ?> left</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200"><?php echo e($product->stock); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3">
                                <?php if($product->is_featured): ?>
                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                <?php else: ?>
                                    <span class="text-navy-700/30">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Edit</a>
                                    <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" onsubmit="return confirm('Delete this product?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No products found</p>
                                <a href="<?php echo e(route('admin.products.create')); ?>" class="text-pulse-500 hover:text-pulse-400 text-sm font-medium">Add your first product</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($products->hasPages()): ?>
            <div class="px-5 py-3 border-t border-navy-100">
                <?php echo e($products->links()); ?>

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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/admin/products/index.blade.php ENDPATH**/ ?>