<?php
    $posts = collect([
        [
            'title' => 'How to Choose the Right Headphones for Your Workflow',
            'slug' => 'choose-right-headphones',
            'excerpt' => 'Open-back vs closed-back, ANC vs passive isolation — we break down what actually matters when picking headphones for work, travel, or studio use.',
            'category' => 'Audio',
            'date' => 'Jul 15, 2026',
            'readTime' => '6 min read',
            'gradient' => 'from-pulse-500 to-navy-700',
        ],
        [
            'title' => 'USB-C Everything: Why One Cable Should Be Enough',
            'slug' => 'usb-c-everything',
            'excerpt' => 'The promise of a single cable for power, data, and display is finally here. We tested five USB-C hubs and docking stations to find the best setups.',
            'category' => 'Accessories',
            'date' => 'Jul 10, 2026',
            'readTime' => '5 min read',
            'gradient' => 'from-navy-700 to-pulse-300',
        ],
        [
            'title' => 'The Rise of Ultrabooks: Thin, Light, and Surprisingly Powerful',
            'slug' => 'rise-of-ultrabooks',
            'excerpt' => 'Modern ultrabooks pack desktop-class performance into sub-3 lb frames. We compare the top five models for battery life, display quality, and raw speed.',
            'category' => 'Computing',
            'date' => 'Jul 5, 2026',
            'readTime' => '8 min read',
            'gradient' => 'from-navy-800 to-pulse-500',
        ],
        [
            'title' => 'Power Banks in 2026: What 100W PD Actually Gets You',
            'slug' => 'power-banks-2026',
            'excerpt' => 'With 100W Power Delivery, a pocket-sized bank can charge your laptop. We tested ten models for real-world output, heat management, and airline compliance.',
            'category' => 'Accessories',
            'date' => 'Jun 28, 2026',
            'readTime' => '7 min read',
            'gradient' => 'from-pulse-400 to-navy-900',
        ],
        [
            'title' => 'Building a Minimal Desk Setup Under $500',
            'slug' => 'minimal-desk-setup',
            'excerpt' => 'A clean desk boosts focus. Here is how to build a functional, good-looking workstation — monitor, keyboard, audio, and lighting — without overspending.',
            'category' => 'Lifestyle',
            'date' => 'Jun 20, 2026',
            'readTime' => '5 min read',
            'gradient' => 'from-navy-600 to-pulse-400',
        ],
        [
            'title' => 'Noise-Cancelling Tech Explained: How ANC Really Works',
            'slug' => 'how-anc-works',
            'excerpt' => 'Microphones, inverted waveforms, and DSP chips — a deep dive into the engineering behind active noise cancellation and why some implementations outperform others.',
            'category' => 'Audio',
            'date' => 'Jun 14, 2026',
            'readTime' => '9 min read',
            'gradient' => 'from-pulse-500 to-navy-900',
        ],
    ]);
?>

<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'Blog — PulseTrade'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    
    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">PulseTrade Journal</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">Latest Articles</h1>
            <p class="text-ivory/60 mt-2 text-sm max-w-lg">Gear guides, deep dives, and honest takes on the electronics we recommend — and the ones we don't.</p>
        </div>
    </div>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <a href="<?php echo e(url('/blog/' . $posts[0]['slug'])); ?>" class="grid lg:grid-cols-2 gap-8 items-center group rounded-3xl border border-navy-100 overflow-hidden hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
            <div class="aspect-[4/3] lg:aspect-square bg-gradient-to-br <?php echo e($posts[0]['gradient']); ?> flex items-center justify-center">
                <svg width="80" height="50" viewBox="0 0 34 24" class="pulse-line opacity-40">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="p-8 lg:p-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-bold tracking-wider uppercase text-pulse-500"><?php echo e($posts[0]['category']); ?></span>
                    <span class="text-xs text-navy-700/40">•</span>
                    <span class="text-xs text-navy-700/50"><?php echo e($posts[0]['date']); ?></span>
                    <span class="text-xs text-navy-700/40">•</span>
                    <span class="text-xs text-navy-700/50"><?php echo e($posts[0]['readTime']); ?></span>
                </div>
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-navy-900 group-hover:text-pulse-500 transition-colors"><?php echo e($posts[0]['title']); ?></h2>
                <p class="mt-4 text-navy-700/70 leading-relaxed text-sm"><?php echo e($posts[0]['excerpt']); ?></p>
                <span class="inline-flex mt-6 text-sm font-semibold text-pulse-500 group-hover:text-pulse-400">Read article →</span>
            </div>
        </a>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">More Articles</span>
                <h2 class="font-display text-2xl font-bold text-navy-900 mt-2">Recent Posts</h2>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $posts->slice(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(url('/blog/' . $post['slug'])); ?>" class="group rounded-2xl border border-navy-100 bg-white overflow-hidden hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                    <div class="aspect-[16/10] bg-gradient-to-br <?php echo e($post['gradient']); ?> flex items-center justify-center">
                        <svg width="60" height="38" viewBox="0 0 34 24" class="pulse-line opacity-30">
                            <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[10px] font-bold tracking-wider uppercase text-pulse-500"><?php echo e($post['category']); ?></span>
                            <span class="text-[10px] text-navy-700/40">•</span>
                            <span class="text-[10px] text-navy-700/50"><?php echo e($post['date']); ?></span>
                        </div>
                        <h3 class="font-display font-semibold text-navy-900 leading-snug group-hover:text-pulse-500 transition-colors"><?php echo e($post['title']); ?></h3>
                        <p class="text-xs text-navy-700/60 mt-2 leading-relaxed line-clamp-2"><?php echo e($post['excerpt']); ?></p>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs text-navy-700/50"><?php echo e($post['readTime']); ?></span>
                            <span class="text-xs font-semibold text-pulse-500 group-hover:text-pulse-400">Read →</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="bg-navy-950 text-white py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-2xl sm:text-3xl font-bold">Stay in the loop</h2>
            <p class="mt-3 text-ivory/60 text-sm">New articles every week — gear guides, reviews, and behind-the-scenes looks at how we test products.</p>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views/blog/index.blade.php ENDPATH**/ ?>