<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<a href="<?php echo e(url('/shop/product/'.$product->slug)); ?>" <?php echo e($attributes->merge(['class' => 'group rounded-2xl border border-navy-100 bg-white overflow-hidden hover:shadow-lg hover:shadow-navy-900/5 transition-shadow'])); ?>>
    <div class="relative aspect-square bg-ivory overflow-hidden">
        <img src="<?php echo e($product->demo_image_url); ?>" alt="<?php echo e($product->name); ?>"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy"
             onerror="this.onerror=null;this.src='<?php echo e(\App\Models\Product::fallbackImageUrl()); ?>';">
        <?php if($product->hasDiscount()): ?>
            <span class="absolute top-3 left-3 bg-white text-navy-900 text-[10px] font-bold px-2 py-1 rounded-full">SALE</span>
        <?php endif; ?>
        <?php if($product->stock <= 0): ?>
            <span class="absolute inset-0 bg-navy-950/60 flex items-center justify-center text-white text-xs font-semibold tracking-wide">OUT OF STOCK</span>
        <?php elseif($product->stock < 5): ?>
            <span class="absolute top-3 right-3 bg-navy-950/80 text-white text-[10px] font-bold px-2 py-1 rounded-full">LOW STOCK</span>
        <?php endif; ?>
    </div>
    <div class="p-4">
        <p class="text-sm font-semibold text-navy-900 leading-snug group-hover:text-pulse-500 transition-colors"><?php echo e($product->name); ?></p>
        <div class="mt-2 flex items-center gap-2">
            <?php if($product->hasDiscount()): ?>
                <span class="text-sm font-bold text-pulse-500"><?php echo e($currency_symbol ?? '$'); ?><?php echo e(number_format($product->sale_price, 0)); ?></span>
                <span class="text-xs text-navy-700/40 line-through"><?php echo e($currency_symbol ?? '$'); ?><?php echo e(number_format($product->price, 0)); ?></span>
            <?php else: ?>
                <span class="text-sm font-bold text-navy-900"><?php echo e($currency_symbol ?? '$'); ?><?php echo e(number_format($product->price, 0)); ?></span>
            <?php endif; ?>
        </div>
    </div>
</a>
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views/components/product-card.blade.php ENDPATH**/ ?>