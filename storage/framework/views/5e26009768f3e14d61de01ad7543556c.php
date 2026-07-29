<?php
    $contactCards = [
        ['title' => 'Email', 'detail' => 'support@pulsetrade.com', 'sub' => 'We reply within 24 hours', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
        ['title' => 'Phone', 'detail' => '+1 (555) 234-5678', 'sub' => 'Mon — Fri, 9am to 6pm EST', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>'],
        ['title' => 'Address', 'detail' => '120 Market Street, San Francisco, CA 94105', 'sub' => 'Walk-ins by appointment', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
    ];

    $socials = ['X', 'IG', 'FB', 'YT'];

    $faqs = [
        ['q' => 'How fast do you ship?', 'a' => 'Orders placed before 2pm EST ship same day. Standard delivery takes 2-3 business days, and free shipping applies to all orders over ' . $currency_symbol . '150.'],
        ['q' => 'What is your return policy?', 'a' => 'You can return any product within 30 days of purchase for a full refund. Items must be in original condition with all accessories included. We cover return shipping on defective items.'],
        ['q' => 'Do you offer international shipping?', 'a' => 'Yes! We ship to over 40 countries. International shipping rates are calculated at checkout. Delivery typically takes 5-10 business days depending on your location.'],
        ['q' => 'How does the warranty work?', 'a' => "Every product comes with a 2-year warranty. If something breaks, contact us with your order number and we'll send a replacement or repair it at no cost. No questions asked."],
    ];
?>

<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'Contact Us — PulseTrade'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <svg class="absolute inset-0 w-full h-full opacity-[0.12]" preserveAspectRatio="none" viewBox="0 0 1440 500">
            <path d="M0 250 H350 L390 80 L470 420 L550 250 H1440" fill="none" stroke="#5C7DFF" stroke-width="2"/>
        </svg>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
            <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-pulse-300 mb-6">
                <span class="w-6 h-px bg-pulse-300"></span> Get in Touch
            </span>
            <h1 class="font-display text-4xl sm:text-5xl font-bold leading-[1.05] tracking-tight">
                We'd love to hear<br>from you.
            </h1>
            <p class="mt-6 text-lg text-ivory/60 max-w-xl mx-auto">
                Questions about an order, a product, or just want to say hi? We're real people and we respond fast.
            </p>
        </div>
    </section>

    
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-[1fr_1.4fr] gap-12">

            
            <div class="space-y-6">
                <?php $__currentLoopData = $contactCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-start gap-4 rounded-2xl border border-navy-100 p-5 hover:shadow-lg hover:shadow-navy-900/5 transition-shadow">
                        <div class="w-11 h-11 rounded-full bg-pulse-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-pulse-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $card['icon']; ?></svg>
                        </div>
                        <div>
                            <p class="font-display font-semibold text-navy-900"><?php echo e($card['title']); ?></p>
                            <p class="text-sm text-navy-700 mt-0.5"><?php echo e($card['detail']); ?></p>
                            <p class="text-xs text-navy-700/50 mt-1"><?php echo e($card['sub']); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <div class="pt-4">
                    <p class="text-sm font-semibold text-navy-900 mb-3">Follow us</p>
                    <div class="flex gap-3">
                        <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" class="w-10 h-10 rounded-full border border-navy-100 flex items-center justify-center text-xs font-bold text-navy-700 hover:border-pulse-500 hover:text-pulse-500 transition-colors">
                                <?php echo e($social); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            
            <div class="rounded-2xl border border-navy-100 bg-white p-8 sm:p-10">
                <h2 class="font-display font-semibold text-xl text-navy-900">Send us a message</h2>
                <p class="text-sm text-navy-700/60 mt-1">Fill out the form below and we'll get back to you.</p>

                <form method="POST" action="<?php echo e(url('/contact')); ?>" class="mt-8 space-y-5">
                    <?php echo csrf_field(); ?>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm font-medium text-navy-900 block mb-1.5">First Name</label>
                            <input type="text" name="first_name" required placeholder="James"
                                class="w-full rounded-lg border-navy-200 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-navy-900 block mb-1.5">Last Name</label>
                            <input type="text" name="last_name" required placeholder="Walker"
                                class="w-full rounded-lg border-navy-200 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-navy-900 block mb-1.5">Email</label>
                        <input type="email" name="email" required placeholder="james@example.com"
                            class="w-full rounded-lg border-navy-200 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-navy-900 block mb-1.5">Subject</label>
                        <select name="subject" required class="w-full rounded-lg border-navy-200 text-sm text-navy-700 focus:border-pulse-500 focus:ring-pulse-500">
                            <option value="" disabled selected>Choose a topic</option>
                            <option>Order Issue</option>
                            <option>Product Question</option>
                            <option>Returns &amp; Warranty</option>
                            <option>Partnership Inquiry</option>
                            <option>General Feedback</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-navy-900 block mb-1.5">Message</label>
                        <textarea name="message" rows="5" required placeholder="Tell us what's on your mind..."
                            class="w-full rounded-lg border-navy-200 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3.5 transition-colors">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    
    <section class="bg-ivory py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="text-xs font-semibold tracking-widest uppercase text-pulse-500">FAQ</span>
                <h2 class="font-display text-3xl font-bold text-navy-900 mt-2">Common questions</h2>
            </div>

            <div class="space-y-4" x-data="{ open: null }">
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-xl border border-navy-100 bg-white overflow-hidden">
                        <button @click="open = open === <?php echo e($i); ?> ? null : <?php echo e($i); ?>"
                            class="w-full flex items-center justify-between px-6 py-4 text-left">
                            <span class="text-sm font-semibold text-navy-900"><?php echo e($faq['q']); ?></span>
                            <svg class="w-4 h-4 text-navy-700/50 shrink-0 transition-transform" :class="open === <?php echo e($i); ?> ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open === <?php echo e($i); ?>" x-collapse x-cloak class="px-6 pb-4">
                            <p class="text-sm text-navy-700/70 leading-relaxed"><?php echo e($faq['a']); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views\contact.blade.php ENDPATH**/ ?>