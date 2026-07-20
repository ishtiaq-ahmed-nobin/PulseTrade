<?php
    // $product, $gallery, $reviews, $related are passed from the route
?>

<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => $product->name.' — PulseTrade'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-navy-700/50">
        <a href="<?php echo e(url('/')); ?>" class="hover:text-pulse-500">Home</a> /
        <a href="<?php echo e(url('/shop')); ?>" class="hover:text-pulse-500">Shop</a> /
        <a href="<?php echo e(url('/shop?category='.$product->category->slug)); ?>" class="hover:text-pulse-500"><?php echo e($product->category->name); ?></a> /
        <span class="text-navy-900"><?php echo e($product->name); ?></span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 grid lg:grid-cols-2 gap-12">

        
        <div x-data="{ active: 0 }">
            <div class="relative aspect-square rounded-3xl overflow-hidden">
                <?php $__empty_1 = true; $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <img x-show="active === <?php echo e($i); ?>" x-cloak src="<?php echo e($url); ?>" alt="<?php echo e($product->name); ?>" class="absolute inset-0 w-full h-full object-cover">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if($product->image_url): ?>
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="absolute inset-0 bg-gradient-to-br from-navy-100 to-navy-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-navy-700/15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if(count($gallery) > 1): ?>
                <div class="grid grid-cols-4 gap-3 mt-4">
                    <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button @click="active = <?php echo e($i); ?>"
                            class="aspect-square rounded-xl overflow-hidden ring-2 transition-all"
                            :class="active === <?php echo e($i); ?> ? 'ring-pulse-500' : 'ring-transparent opacity-70 hover:opacity-100'">
                            <img src="<?php echo e($url); ?>" alt="Thumbnail <?php echo e($i + 1); ?>" class="w-full h-full object-cover">
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div>
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500"><?php echo e($product->category->name); ?></span>
            <h1 class="font-display text-3xl font-bold text-navy-900 mt-2"><?php echo e($product->name); ?></h1>

            <div class="flex items-center gap-3 mt-3">
                <?php $avg = $product->averageRating(); ?>
                <div class="flex gap-0.5">
                    <?php for($i = 0; $i < 5; $i++): ?>
                        <span class="w-3.5 h-3.5 rounded-full <?php echo e($i < floor($avg) ? 'bg-pulse-500' : 'bg-navy-100'); ?>"></span>
                    <?php endfor; ?>
                </div>
                <span class="text-sm text-navy-700/60"><?php echo e(number_format($avg, 1)); ?> (<?php echo e($reviews->count()); ?> reviews)</span>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <span class="text-3xl font-bold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->final_price, 0)); ?></span>
                <?php if($product->hasDiscount()): ?>
                    <span class="text-lg text-navy-700/40 line-through"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price, 0)); ?></span>
                    <span class="text-xs font-bold text-pulse-500 bg-pulse-100 px-2 py-1 rounded-full">Save <?php echo e(round((1 - $product->sale_price/$product->price)*100)); ?>%</span>
                <?php endif; ?>
            </div>

            <p class="mt-2 text-sm font-medium <?php echo e($product->stock > 0 ? 'text-emerald-600' : 'text-red-500'); ?>">
                <?php echo e($product->stock > 0 ? '● In Stock — ready to ship' : '● Out of Stock'); ?>

            </p>

            <p class="mt-6 text-navy-700/70 leading-relaxed text-sm"><?php echo e($product->description); ?></p>

            <form action="<?php echo e(url('/cart')); ?>" method="POST" class="mt-8 flex items-center gap-4" x-data="{ qty: 1 }">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <input type="hidden" name="qty" :value="qty">
                <div class="flex items-center border border-navy-100 rounded-full">
                    <button type="button" @click="qty = Math.max(1, qty - 1)" class="w-10 h-10 flex items-center justify-center text-navy-700 hover:text-pulse-500">−</button>
                    <span class="w-8 text-center text-sm font-semibold" x-text="qty"></span>
                    <button type="button" @click="qty = qty + 1" class="w-10 h-10 flex items-center justify-center text-navy-700 hover:text-pulse-500">+</button>
                </div>
                <button type="submit" class="flex-1 rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3.5 transition-colors">
                    Add to Cart
                </button>
            </form>

            <div class="mt-8 grid grid-cols-2 gap-4 text-xs text-navy-700/60">
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pulse-500"></span> Free shipping over <?php echo e($currency_symbol); ?>150</div>
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pulse-500"></span> 2-year warranty included</div>
            </div>
        </div>
    </div>

    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20" x-data="{ tab: 'description' }">
        <div class="flex gap-8 border-b border-navy-100">
            <button @click="tab = 'description'" class="pb-4 text-sm font-semibold transition-colors"
                :class="tab === 'description' ? 'text-navy-900 border-b-2 border-pulse-500' : 'text-navy-700/50'">
                Description
            </button>
            <button @click="tab = 'reviews'" class="pb-4 text-sm font-semibold transition-colors"
                :class="tab === 'reviews' ? 'text-navy-900 border-b-2 border-pulse-500' : 'text-navy-700/50'">
                Reviews (<?php echo e($reviews->count()); ?>)
            </button>
        </div>

        <div x-show="tab === 'description'" class="py-8 max-w-3xl text-sm text-navy-700/70 leading-relaxed">
            <?php echo e($product->description); ?>

        </div>

        <div x-show="tab === 'reviews'" x-cloak class="py-8 grid md:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rounded-2xl bg-ivory p-6">
                    <div class="flex gap-0.5 mb-3">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <span class="w-3 h-3 rounded-full <?php echo e($i < $r->rating ? 'bg-pulse-500' : 'bg-navy-100'); ?>"></span>
                        <?php endfor; ?>
                    </div>
                    <p class="text-sm text-navy-800 leading-relaxed">&ldquo;<?php echo e($r->comment); ?>&rdquo;</p>
                    <p class="text-sm font-semibold text-navy-900 mt-4"><?php echo e($r->user->name ?? 'Anonymous'); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="md:col-span-3 text-center py-12 text-navy-700/40 text-sm">No reviews yet. Be the first to review this product.</div>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($related->count()): ?>
    <div class="bg-ivory py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-navy-900 mb-8">You may also like</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('/shop/product/'.$item->slug)); ?>" class="group rounded-2xl border border-navy-100 bg-white overflow-hidden hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <?php if($item->image_url): ?>
                            <div class="aspect-square bg-ivory overflow-hidden">
                                <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </div>
                        <?php else: ?>
                            <div class="aspect-square bg-gradient-to-br from-navy-100 to-navy-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-navy-700/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        <?php endif; ?>
                        <div class="p-4">
                            <p class="text-sm font-semibold text-navy-900 group-hover:text-pulse-500 transition-colors"><?php echo e($item->name); ?></p>
                            <div class="mt-2 flex items-center gap-2">
                                <?php if($item->hasDiscount()): ?>
                                    <span class="text-sm font-bold text-pulse-500"><?php echo e($currency_symbol); ?><?php echo e(number_format($item->sale_price, 0)); ?></span>
                                    <span class="text-xs text-navy-700/40 line-through"><?php echo e($currency_symbol); ?><?php echo e(number_format($item->price, 0)); ?></span>
                                <?php else: ?>
                                    <span class="text-sm font-bold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($item->price, 0)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views/shop/show.blade.php ENDPATH**/ ?>