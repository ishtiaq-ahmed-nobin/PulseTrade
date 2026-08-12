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
            <h1 class="text-xl font-display font-bold text-navy-900">Categories</h1>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="inline-flex items-center gap-2 bg-pulse-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Category
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Slug</th>
                        <th class="px-5 py-3 font-medium">Parent</th>
                        <th class="px-5 py-3 font-medium">Products</th>
                        <th class="px-5 py-3 font-medium">Children</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-navy-900"><?php echo e($category->name); ?></td>
                            <td class="px-5 py-3 text-navy-700/60 font-mono text-xs"><?php echo e($category->slug); ?></td>
                            <td class="px-5 py-3 text-navy-700/60"><?php echo e($category->parent?->name ?? '—'); ?></td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-navy-50 text-navy-700">
                                    <?php echo e($category->products_count); ?>

                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <?php if($category->children->count()): ?>
                                    <div class="flex flex-wrap gap-1">
                                        <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-pulse-100 text-pulse-500">
                                                <?php echo e($child->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-navy-700/30">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Edit</a>
                                    <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category)); ?>" onsubmit="return confirm('Delete this category? Products in it will be orphaned.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php if($category->children->count()): ?>
                            <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-ivory/50 transition-colors bg-ivory/30">
                                    <td class="px-5 py-3 pl-10 font-medium text-navy-900">
                                        <span class="text-navy-700/30 mr-2">└</span><?php echo e($child->name); ?>

                                    </td>
                                    <td class="px-5 py-3 text-navy-700/60 font-mono text-xs"><?php echo e($child->slug); ?></td>
                                    <td class="px-5 py-3 text-navy-700/60"><?php echo e($category->name); ?></td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-navy-50 text-navy-700">
                                            <?php echo e($child->products_count ?? $child->products()->count()); ?>

                                        </span>
                                    </td>
                                    <td class="px-5 py-3">—</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="<?php echo e(route('admin.categories.edit', $child)); ?>" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Edit</a>
                                            <form method="POST" action="<?php echo e(route('admin.categories.destroy', $child)); ?>" onsubmit="return confirm('Delete this category?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No categories yet</p>
                                <a href="<?php echo e(route('admin.categories.create')); ?>" class="text-pulse-500 hover:text-pulse-400 text-sm font-medium">Create your first category</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>