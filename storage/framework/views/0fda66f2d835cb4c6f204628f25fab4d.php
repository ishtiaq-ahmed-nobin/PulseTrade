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
            <a href="<?php echo e(route('admin.products.index')); ?>" class="text-navy-700/60 hover:text-navy-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-display font-bold text-navy-900">Edit Product</h1>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl">
        <form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" enctype="multipart/form-data"
              class="bg-white rounded-xl border border-navy-100 p-6 space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-navy-700 mb-1">Product Name *</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $product->name)); ?>" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-navy-700 mb-1">Category *</label>
                    <select name="category_id" id="category_id" required
                            class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                        <option value="">Select Category</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id) == $cat->id ? 'selected' : ''); ?>>
                                <?php echo e($cat->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-navy-700 mb-1">Description *</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"><?php echo e(old('description', $product->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="price" class="block text-sm font-medium text-navy-700 mb-1">Price (<?php echo e($currency_symbol); ?>) *</label>
                    <input type="number" name="price" id="price" value="<?php echo e(old('price', $product->price)); ?>" step="0.01" min="0" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="sale_price" class="block text-sm font-medium text-navy-700 mb-1">Sale Price (<?php echo e($currency_symbol); ?>)</label>
                    <input type="number" name="sale_price" id="sale_price" value="<?php echo e(old('sale_price', $product->sale_price)); ?>" step="0.01" min="0"
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-navy-700 mb-1">Stock *</label>
                    <input type="number" name="stock" id="stock" value="<?php echo e(old('stock', $product->stock)); ?>" min="0" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-navy-700 mb-1">Main Image</label>
                <div class="flex items-center gap-4">
                    <label for="image" class="cursor-pointer bg-ivory border-2 border-dashed border-navy-200 rounded-lg px-6 py-8 text-center hover:border-pulse-500 transition-colors flex-1">
                        <svg class="w-8 h-8 mx-auto text-navy-700/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-navy-700/60">Click to replace main image</p>
                        <p class="text-xs text-navy-700/40 mt-1">Leave empty to keep current image</p>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                    <div class="w-24 h-24 rounded-lg overflow-hidden bg-ivory border border-navy-100 shrink-0">
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover"
                             onerror="this.onerror=null;this.src='<?php echo e(\App\Models\Product::fallbackImageUrl()); ?>';">
                    </div>
                </div>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="mt-3">
                    <label for="image_url" class="block text-sm font-medium text-navy-700 mb-1">Or Image URL</label>
                    <input type="url" name="image_url" id="image_url" value="<?php echo e(old('image_url', str_starts_with((string) $product->image, 'http') ? $product->image : '')); ?>"
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                           placeholder="https://images.unsplash.com/...">
                    <p class="text-xs text-navy-700/40 mt-1">Uploading a file or entering a URL replaces the current main image.</p>
                    <?php $__errorArgs = ['image_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <?php if(count($product->gallery_images)): ?>
                <div>
                    <label class="block text-sm font-medium text-navy-700 mb-1">Current Gallery</label>
                    <div class="flex gap-2 flex-wrap">
                        <?php $__currentLoopData = $product->gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-navy-100">
                                <img src="<?php echo e(str_starts_with($img, 'http') ? $img : asset('storage/' . $img)); ?>" class="w-full h-full object-cover"
                                     onerror="this.onerror=null;this.src='<?php echo e(\App\Models\Product::fallbackImageUrl()); ?>';">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-navy-700 mb-1">Upload New Gallery Images</label>
                <label class="cursor-pointer bg-ivory border-2 border-dashed border-navy-200 rounded-lg px-6 py-6 text-center hover:border-pulse-500 transition-colors block">
                    <svg class="w-6 h-6 mx-auto text-navy-700/30 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-navy-700/60">Replace all gallery images (upload new set)</p>
                    <input type="file" name="images[]" accept="image/*" multiple class="hidden">
                </label>
                <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="mt-3 space-y-2">
                    <label class="block text-sm font-medium text-navy-700">Add Gallery Image URLs</label>
                    <?php for($i = 0; $i < 3; $i++): ?>
                        <input type="url" name="gallery_urls[]" value="<?php echo e(old('gallery_urls.'.$i)); ?>"
                               class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                               placeholder="https://images.unsplash.com/...">
                    <?php endfor; ?>
                    <?php $__errorArgs = ['gallery_urls.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                       <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?>

                       class="rounded border-navy-300 text-pulse-500 focus:ring-pulse-500">
                <label for="is_featured" class="text-sm font-medium text-navy-700">Featured product</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-pulse-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                    Update Product
                </button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Cancel</a>
            </div>
        </form>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views\admin\products\edit.blade.php ENDPATH**/ ?>