<?php
    $faqGroups = [
        'Orders & Shipping' => [
            ['q' => 'How fast do you ship?', 'a' => 'Orders placed before 2pm EST ship same day. Standard delivery takes 2-3 business days, and free shipping applies to all orders over ' . $currency_symbol . '150.'],
            ['q' => 'Do you offer international shipping?', 'a' => 'Yes! We ship to over 40 countries. International shipping rates are calculated at checkout. Delivery typically takes 5-10 business days depending on your location.'],
            ['q' => 'How can I track my order?', 'a' => 'Once your order ships, you will receive an email with a tracking number. You can use it to follow your package in real time via the carrier\'s website or app.'],
            ['q' => 'Can I change or cancel my order after placing it?', 'a' => 'We process orders quickly. If your order hasn\'t shipped yet, contact our support team within 1 hour and we\'ll do our best to make changes. Once shipped, changes are no longer possible.'],
        ],
        'Returns & Warranty' => [
            ['q' => 'What is your return policy?', 'a' => 'You can return any product within 30 days of purchase for a full refund. Items must be in original condition with all accessories included. We cover return shipping on defective items.'],
            ['q' => 'How does the warranty work?', 'a' => 'Every product comes with a 2-year warranty. If something breaks, contact us with your order number and we\'ll send a replacement or repair it at no cost. No questions asked.'],
            ['q' => 'How do I start a return or warranty claim?', 'a' => 'Email us at support@pulsetrade.com with your order number and a description of the issue. For warranty claims, include photos if possible. We typically respond within 24 hours.'],
            ['q' => 'Do you offer refunds on sale items?', 'a' => 'Yes. Sale items follow the same return policy as full-price items. You can return them within 30 days for a full refund to your original payment method.'],
        ],
        'Products & Payments' => [
            ['q' => 'Are your products genuine?', 'a' => 'Absolutely. Every product in our catalog is sourced directly from authorized distributors or the manufacturers themselves. We do not sell refurbished, counterfeit, or gray-market goods.'],
            ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit and debit cards (Visa, Mastercard, Amex), PayPal, Apple Pay, Google Pay, and Shop Pay. All transactions are encrypted and secure.'],
            ['q' => 'Do you offer financing or installments?', 'a' => 'Yes. At checkout you can choose to split your purchase into 4 interest-free payments through our partner. The first payment is charged at checkout and the rest are billed every two weeks.'],
            ['q' => 'Can I buy a gift card?', 'a' => 'Gift cards are available in denominations from ' . $currency_symbol . '25 to ' . $currency_symbol . '500. They are delivered instantly via email and never expire.'],
        ],
        'Account & Support' => [
            ['q' => 'Do I need an account to place an order?', 'a' => 'No. You can check out as a guest. However, creating an account lets you track orders, save addresses, and access your purchase history.'],
            ['q' => 'How do I contact support?', 'a' => 'You can reach us via email at support@pulsetrade.com, by phone at +1 (555) 234-5678 (Mon–Fri, 9am–6pm EST), or through the contact form on our website. We typically respond within a few hours.'],
            ['q' => 'Is my personal data safe?', 'a' => 'Yes. We use industry-standard encryption and never store your full credit card number. We do not sell or share your personal information with third parties. See our Privacy Policy for details.'],
        ],
    ];
?>

<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'FAQ — PulseTrade'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    
    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Help Center</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">Frequently Asked Questions</h1>
            <p class="text-ivory/60 mt-2 text-sm max-w-lg mx-auto">Everything you need to know about ordering, shipping, returns, and your account. Can't find what you're looking for? <a href="<?php echo e(url('/contact')); ?>" class="text-pulse-400 hover:text-pulse-300 font-medium">Contact us</a>.</p>
        </div>
    </div>

    
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
        <?php $__currentLoopData = $faqGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $faqs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <h2 class="font-display text-xl font-bold text-navy-900 mb-5 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-pulse-500 shrink-0"></span>
                    <?php echo e($group); ?>

                </h2>
                <div class="space-y-3" x-data="{ open: null }">
                    <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-xl border border-navy-100 bg-white overflow-hidden">
                            <button @click="open = open === '<?php echo e($group); ?>-<?php echo e($i); ?>' ? null : '<?php echo e($group); ?>-<?php echo e($i); ?>'"
                                class="w-full flex items-center justify-between px-6 py-4 text-left">
                                <span class="text-sm font-semibold text-navy-900 pr-4"><?php echo e($faq['q']); ?></span>
                                <svg class="w-4 h-4 text-navy-700/50 shrink-0 transition-transform" :class="open === '<?php echo e($group); ?>-<?php echo e($i); ?>' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === '<?php echo e($group); ?>-<?php echo e($i); ?>'" x-collapse x-cloak class="px-6 pb-4">
                                <p class="text-sm text-navy-700/70 leading-relaxed"><?php echo e($faq['a']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    
    <section class="bg-ivory py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-2xl font-bold text-navy-900">Still have questions?</h2>
            <p class="mt-3 text-navy-700/60 text-sm">Our support team is real people who respond fast. Reach out and we'll get back to you within a few hours.</p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(url('/contact')); ?>" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-pulse-500 hover:bg-pulse-400 text-white font-semibold text-sm transition-colors">
                    Contact Support
                </a>
                <a href="mailto:support@pulsetrade.com" class="inline-flex items-center justify-center px-7 py-3.5 rounded-full border border-navy-200 text-navy-700 font-semibold text-sm hover:border-pulse-500 hover:text-pulse-500 transition-colors">
                    support@pulsetrade.com
                </a>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views\faq.blade.php ENDPATH**/ ?>