<?php
    $testimonials = [
        ['quote' => 'Packaging alone felt premium — the earbuds sound even better than the site promised.', 'name' => 'Marcus T.', 'role' => 'Verified Buyer'],
        ['quote' => 'Ordered the Zenith laptop on a Monday, was unboxing it by Wednesday. Zero hassle.', 'name' => 'Priya S.', 'role' => 'Verified Buyer'],
        ['quote' => 'Their support team swapped a faulty unit in two days, no questions asked.', 'name' => 'Daniel K.', 'role' => 'Verified Buyer'],
    ];
    $usps = [
        ['label' => 'Free Shipping', 'sub' => 'On orders over ' . $currency_symbol . '150'],
        ['label' => 'Secure Payment', 'sub' => 'Encrypted checkout'],
        ['label' => '2-Year Warranty', 'sub' => 'On every device'],
        ['label' => '24/7 Support', 'sub' => 'Real humans, fast replies'],
    ];
    $fallbackImage = \App\Models\Product::fallbackImageUrl();
?>

<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'PulseTrade — Electronics Built For The Everyday Edge'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <svg class="absolute inset-0 w-full h-full opacity-[0.15]" preserveAspectRatio="none" viewBox="0 0 1440 600">
            <path d="M0 300 H400 L440 120 L520 480 L600 300 H1440" fill="none" stroke="#5C7DFF" stroke-width="2"/>
        </svg>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-pulse-300 mb-6">
                    <span class="w-6 h-px bg-pulse-300"></span> New Season Drop
                </span>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.05] tracking-tight">
                    Tech that keeps pace<br class="hidden sm:block"> with your pulse.
                </h1>
                <p class="mt-6 text-lg text-ivory/70 max-w-md">
                    Curated audio, wearables, and computing gear — tested for performance, warrantied for peace of mind.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="<?php echo e(url('/shop')); ?>" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-pulse-500 hover:bg-pulse-400 font-semibold text-sm transition-colors">
                        Shop the Collection
                    </a>
                    <a href="<?php echo e(url('/shop?category=audio')); ?>" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full border border-white/20 hover:border-white/40 font-semibold text-sm transition-colors">
                        Explore Audio
                    </a>
                </div>
            </div>
            <div class="relative aspect-square rounded-3xl bg-gradient-to-br from-pulse-500/30 to-navy-700/60 border border-white/10 flex items-center justify-center">
                <svg width="160" height="100" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#8FA4FF" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </section>

    
    <section class="border-b border-navy-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-2 md:grid-cols-4 gap-8">
            <?php $__currentLoopData = $usps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-start gap-3">
                    <span class="mt-1 w-2 h-2 rounded-full bg-pulse-500 shrink-0"></span>
                    <div>
                        <p class="font-semibold text-sm text-navy-900"><?php echo e($usp['label']); ?></p>
                        <p class="text-xs text-navy-700/60 mt-0.5"><?php echo e($usp['sub']); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Browse</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Shop by Category</h2>
            </div>
            <a href="<?php echo e(url('/shop')); ?>" class="hidden sm:inline text-sm font-semibold text-pulse-500 hover:text-pulse-400">View all →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(url('/shop?category='.$cat->slug)); ?>" class="group rounded-2xl border border-navy-100 hover:border-pulse-300 p-5 text-center transition-colors">
                    <div class="mx-auto w-12 h-12 rounded-full bg-ivory flex items-center justify-center mb-3 group-hover:bg-pulse-100 transition-colors">
                        <span class="w-3 h-3 rounded-full bg-navy-800 group-hover:bg-pulse-500"></span>
                    </div>
                    <p class="text-sm font-semibold text-navy-900"><?php echo e($cat->name); ?></p>
                    <p class="text-xs text-navy-700/50 mt-0.5"><?php echo e($cat->products_count); ?> items</p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="bg-ivory py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Handpicked</span>
                    <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Featured Products</h2>
                </div>
                <a href="<?php echo e(url('/shop')); ?>" class="hidden sm:inline text-sm font-semibold text-pulse-500 hover:text-pulse-400">View all →</a>
            </div>
            <div class="flex gap-5 overflow-x-auto pb-4 -mx-4 px-4 snap-x">
                <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product,'class' => 'snap-start shrink-0 w-64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'class' => 'snap-start shrink-0 w-64']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="mb-10">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Most Loved</span>
            <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Best Sellers</h2>
        </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('/shop/product/'.$product->slug)); ?>" class="relative rounded-2xl border border-navy-100 p-5 hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <span class="absolute top-4 right-4 text-xs font-bold text-navy-700/30">#<?php echo e($i + 1); ?></span>
                        <div class="aspect-square rounded-xl overflow-hidden mb-4">
                            <img src="<?php echo e($product->demo_image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover" loading="lazy"
                                 onerror="this.onerror=null;this.src='<?php echo e($fallbackImage); ?>';">
                        </div>
                        <p class="text-sm font-semibold text-navy-900"><?php echo e($product->name); ?></p>
                        <p class="text-xs text-navy-700/50 mt-1"><?php echo e($product->reviews_count); ?> reviews</p>
                        <p class="text-sm font-bold text-navy-900 mt-2"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price, 0)); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="relative overflow-hidden rounded-3xl bg-navy-950 text-white px-8 py-16 sm:px-16 text-center">
            <svg class="absolute inset-0 w-full h-full opacity-10" preserveAspectRatio="none" viewBox="0 0 1440 300">
                <path d="M0 150 H500 L540 40 L600 260 H1440" fill="none" stroke="#8FA4FF" stroke-width="2"/>
            </svg>
            <div class="relative">
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Limited Time</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold mt-3">Up to 30% off selected gear</h2>
                <p class="mt-3 text-ivory/70">Ends when the stock runs out — not a day later.</p>
                <a href="<?php echo e(url('/shop?sale=1')); ?>" class="inline-flex mt-7 px-7 py-3.5 rounded-full bg-white text-navy-900 font-semibold text-sm hover:bg-pulse-100 transition-colors">
                    Shop the Sale
                </a>
            </div>
        </div>
    </section>

    
    <section class="bg-ivory py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Just Landed</span>
                    <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">New Arrivals</h2>
                </div>
                <a href="<?php echo e(url('/shop?sort=newest')); ?>" class="hidden sm:inline text-sm font-semibold text-pulse-500 hover:text-pulse-400">View all →</a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('/shop/product/'.$product->slug)); ?>" class="rounded-2xl bg-white border border-navy-100 p-5 hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <div class="aspect-square rounded-xl overflow-hidden mb-4">
                            <img src="<?php echo e($product->demo_image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover" loading="lazy"
                                 onerror="this.onerror=null;this.src='<?php echo e($fallbackImage); ?>';">
                        </div>
                        <span class="text-[10px] font-bold tracking-wider uppercase text-pulse-500">New</span>
                        <p class="text-sm font-semibold text-navy-900 mt-1"><?php echo e($product->name); ?></p>
                        <p class="text-sm font-bold text-navy-900 mt-2"><?php echo e($currency_symbol); ?><?php echo e(number_format($product->price, 0)); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-10 items-center rounded-3xl border border-navy-100 p-8 sm:p-12">
            <div class="aspect-video lg:aspect-square rounded-2xl bg-gradient-to-br from-pulse-500 to-navy-800"></div>
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Deal of the Day</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Zenith 14" Ultrabook</h2>
                <p class="mt-3 text-navy-700/70">Featherweight magnesium chassis, all-day battery, and a display sharp enough for color-critical work.</p>
                <div class="mt-5 flex items-center gap-3">
                    <span class="text-2xl font-bold text-navy-900"><?php echo e($currency_symbol); ?>1,299</span>
                    <span class="text-sm text-navy-700/40 line-through"><?php echo e($currency_symbol); ?>1,499</span>
                    <span class="text-xs font-bold text-pulse-500 bg-pulse-100 px-2 py-1 rounded-full">Save 13%</span>
                </div>
                <div class="mt-6 flex gap-3">
                    <?php $__currentLoopData = ['14', '06', '48']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="w-16 rounded-xl bg-ivory text-center py-3">
                            <p class="font-display font-bold text-lg text-navy-900"><?php echo e($unit); ?></p>
                            <p class="text-[10px] uppercase text-navy-700/50"><?php echo e($loop->first ? 'hrs' : ($loop->iteration == 2 ? 'min' : 'sec')); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a href="<?php echo e(url('/shop/product')); ?>" class="inline-flex mt-7 px-7 py-3.5 rounded-full bg-navy-900 text-white font-semibold text-sm hover:bg-navy-800 transition-colors">
                    Claim This Deal
                </a>
            </div>
        </div>
    </section>

    
    <section class="bg-navy-950 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Our Standard</span>
                <h2 class="font-display text-3xl font-bold mt-2">Why people choose PulseTrade</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php $__currentLoopData = [
                    ['title' => 'Curated Selection', 'body' => 'Every product is chosen, not just listed — we reject more gear than we stock.'],
                    ['title' => 'Verified Quality', 'body' => 'Bench-tested for build, battery, and performance before it reaches the catalog.'],
                    ['title' => 'Fast Delivery', 'body' => 'Most orders ship same-day and arrive within 48 hours.'],
                    ['title' => 'Expert Support', 'body' => 'Real specialists who know the difference between a driver and a DAC.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div class="w-10 h-10 rounded-full border border-pulse-400/40 flex items-center justify-center mb-4">
                            <span class="w-2 h-2 rounded-full bg-pulse-400"></span>
                        </div>
                        <h3 class="font-display font-semibold text-lg"><?php echo e($point['title']); ?></h3>
                        <p class="text-sm text-ivory/60 mt-2"><?php echo e($point['body']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">Real Reviews</span>
            <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">What customers are saying</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-2xl bg-ivory p-7">
                    <div class="flex gap-0.5 mb-4">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <span class="w-3.5 h-3.5 rounded-full bg-pulse-500"></span>
                        <?php endfor; ?>
                    </div>
                    <p class="text-sm text-navy-800 leading-relaxed">&ldquo;<?php echo e($t['quote']); ?>&rdquo;</p>
                    <p class="text-sm font-semibold text-navy-900 mt-5"><?php echo e($t['name']); ?></p>
                    <p class="text-xs text-navy-700/50"><?php echo e($t['role']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="border-y border-navy-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-8">
            <?php $__currentLoopData = ['Voltix', 'Ampere Labs', 'Northwind Audio', 'Circuitry Co.', 'GridPoint']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="font-display font-semibold text-navy-900/30 text-lg tracking-tight"><?php echo e($brand); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="bg-navy-950 text-white py-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl font-bold">Get 10% off your first order</h2>
            <p class="mt-3 text-ivory/60">Product drops, restocks, and the occasional pulse-check on what's worth buying. No spam.</p>
            <form action="#" method="POST" class="mt-8 flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="you@email.com" required
                    class="flex-1 rounded-full border-0 bg-white/10 px-5 py-3.5 text-sm text-white placeholder:text-ivory/40 focus:ring-2 focus:ring-pulse-400">
                <button type="submit" class="rounded-full bg-pulse-500 hover:bg-pulse-400 px-6 py-3.5 text-sm font-semibold transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views/home.blade.php ENDPATH**/ ?>