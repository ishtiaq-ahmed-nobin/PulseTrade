<?php if (isset($component)) { $__componentOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f1a0b43b0f4913ab52eb9d7d7a32462 = $attributes; } ?>
<?php $component = App\View\Components\StorefrontLayout::resolve(['title' => 'Checkout — PulseTrade','cartCount' => count($items)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\StorefrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Step 2 of 2</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">Checkout</h1>
        </div>
    </div>

    <form action="<?php echo e(route('checkout.store')); ?>" method="POST"
          class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[1fr_380px] gap-10"
          x-data="{ payment: 'card', processing: false }"
          @submit="processing = true">
        <?php echo csrf_field(); ?>

        <div class="space-y-10">
            <div>
                <h2 class="font-display font-semibold text-lg text-navy-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-navy-900 text-white text-xs flex items-center justify-center">1</span>
                    Shipping Details
                </h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Full Name</label>
                        <input type="text" name="name" required placeholder="Jordan Rivera" value="<?php echo e(old('name', auth()->user()->name ?? '')); ?>"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Email</label>
                        <input type="email" name="email" required placeholder="you@example.com" value="<?php echo e(old('email', auth()->user()->email ?? '')); ?>"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Shipping Address</label>
                        <input type="text" name="address" required placeholder="221B Circuit Lane" value="<?php echo e(old('address', auth()->user()->address ?? '')); ?>"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">City</label>
                        <input type="text" name="city" required placeholder="New York"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Postal Code</label>
                        <input type="text" name="postal_code" required placeholder="10001"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Phone</label>
                        <input type="tel" name="phone" required placeholder="+1 (555) 000-0000" value="<?php echo e(old('phone', auth()->user()->phone ?? '')); ?>"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                </div>
            </div>

            <div>
                <h2 class="font-display font-semibold text-lg text-navy-900 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-navy-900 text-white text-xs flex items-center justify-center">2</span>
                    Payment Method
                </h2>

                <div class="grid sm:grid-cols-2 gap-4 mb-6">
                    <button type="button" @click="payment = 'card'"
                        class="rounded-xl border p-4 text-left transition-colors"
                        :class="payment === 'card' ? 'border-pulse-500 bg-pulse-100/50' : 'border-navy-100'">
                        <p class="font-semibold text-sm text-navy-900">Credit / Debit Card</p>
                        <p class="text-xs text-navy-700/50 mt-1">Simulated card payment</p>
                    </button>
                    <button type="button" @click="payment = 'cod'"
                        class="rounded-xl border p-4 text-left transition-colors"
                        :class="payment === 'cod' ? 'border-pulse-500 bg-pulse-100/50' : 'border-navy-100'">
                        <p class="font-semibold text-sm text-navy-900">Cash on Delivery</p>
                        <p class="text-xs text-navy-700/50 mt-1">Pay when it arrives</p>
                    </button>
                </div>

                <input type="hidden" name="payment_method" :value="payment">

                <div x-show="payment === 'card'" x-cloak class="rounded-xl border border-navy-100 p-5 space-y-4 bg-ivory">
                    <div>
                        <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Card Number</label>
                        <input type="text" placeholder="4242 4242 4242 4242" maxlength="19"
                               class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-navy-700 mb-1.5 block">Expiry</label>
                            <input type="text" placeholder="MM / YY"
                                   class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-navy-700 mb-1.5 block">CVC</label>
                            <input type="text" placeholder="123"
                                   class="w-full rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        </div>
                    </div>
                    <p class="text-[11px] text-navy-700/40">This is a simulated checkout — no real charge will be made.</p>
                </div>

                <div x-show="payment === 'cod'" x-cloak class="rounded-xl border border-navy-100 p-5 bg-ivory text-sm text-navy-700/70">
                    Pay in cash when your order is delivered. A team member will confirm by phone before dispatch.
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-navy-100 p-6 h-fit sticky top-24"
             x-data="couponSection()" x-init="init()">
            <h2 class="font-display font-semibold text-navy-900 mb-5">Order Summary</h2>
            <div class="space-y-3 mb-4">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-navy-700/70"><?php echo e($item['product']->name); ?> × <?php echo e($item['qty']); ?></span>
                        <span class="font-semibold text-navy-900"><?php echo e($currency_symbol); ?><?php echo e(number_format($item['line_total'], 2)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="border-t border-navy-100 pt-4 mb-4">
                <template x-if="couponCode">
                    <div class="flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span class="text-sm font-semibold text-emerald-700" x-text="couponCode"></span>
                        </div>
                        <button type="button" @click="removeCoupon()" class="text-xs text-emerald-600 hover:text-emerald-800 font-medium">Remove</button>
                    </div>
                </template>
                <template x-if="!couponCode">
                    <div class="flex gap-2">
                        <input type="text" x-model="couponInput" placeholder="Coupon code"
                               class="flex-1 rounded-lg border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500 px-3 py-2">
                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                class="rounded-lg bg-navy-900 text-white text-sm font-semibold px-4 py-2 hover:bg-navy-800 transition-colors whitespace-nowrap disabled:opacity-50">
                            <span x-show="!couponLoading">Apply</span>
                            <span x-show="couponLoading" x-cloak>...</span>
                        </button>
                    </div>
                </template>
                <p x-show="couponError" x-cloak class="text-xs text-red-500 mt-1.5" x-text="couponError"></p>
                <p x-show="couponSuccess" x-cloak class="text-xs text-emerald-600 mt-1.5" x-text="couponSuccess"></p>
                <input type="hidden" name="coupon_code" :value="couponCode">
            </div>

            <div class="border-t border-navy-100 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-navy-700/70">
                    <span>Subtotal</span>
                    <span x-text="'<?php echo e($currency_symbol); ?>' + Number(subtotal).toFixed(2)"><?php echo e($currency_symbol); ?><?php echo e(number_format($subtotal, 2)); ?></span>
                </div>
                <div class="flex justify-between text-navy-700/70">
                    <span>Shipping</span>
                    <span x-text="shippingLabel"><?php echo e($shipping === 0 ? 'Free' : $currency_symbol.number_format($shipping, 2)); ?></span>
                </div>
                <div x-show="discount > 0" x-cloak class="flex justify-between text-emerald-600 font-medium">
                    <span>Discount</span>
                    <span x-text="'-' + '<?php echo e($currency_symbol); ?>' + Number(discount).toFixed(2)">-<?php echo e($currency_symbol); ?><?php echo e(number_format($discount, 2)); ?></span>
                </div>
            </div>
            <div class="border-t border-navy-100 mt-4 pt-4 flex justify-between">
                <span class="font-semibold text-navy-900">Total</span>
                <span class="font-display font-bold text-lg text-navy-900"
                      x-text="'<?php echo e($currency_symbol); ?>' + Number(total).toFixed(2)"><?php echo e($currency_symbol); ?><?php echo e(number_format($total, 2)); ?></span>
            </div>

            <button type="submit" :disabled="processing"
                class="mt-6 w-full rounded-full bg-pulse-500 hover:bg-pulse-400 disabled:opacity-70 text-white font-semibold text-sm py-3.5 transition-colors flex items-center justify-center gap-2">
                <svg x-show="processing" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span x-text="processing ? 'Processing…' : 'Place Order'"></span>
            </button>
            <p class="text-center text-[11px] text-navy-700/40 mt-4">By placing your order you agree to our Terms &amp; Return Policy.</p>
        </div>
    </form>

    <script>
        function couponSection() {
            return {
                couponCode: <?php echo \Illuminate\Support\Js::from($couponCode)->toHtml() ?>,
                couponInput: '',
                couponError: '',
                couponSuccess: '',
                couponLoading: false,
                subtotal: <?php echo \Illuminate\Support\Js::from($subtotal)->toHtml() ?>,
                shipping: <?php echo \Illuminate\Support\Js::from($shipping)->toHtml() ?>,
                shippingLabel: <?php echo \Illuminate\Support\Js::from($shipping === 0 ? 'Free' : number_format($shipping, 2))->toHtml() ?>,
                discount: <?php echo \Illuminate\Support\Js::from($discount)->toHtml() ?>,
                total: <?php echo \Illuminate\Support\Js::from($total)->toHtml() ?>,

                init() {
                    this.couponSuccess = <?php echo \Illuminate\Support\Js::from(session('coupon_success') ?? '')->toHtml() ?>;
                    if (this.couponSuccess) {
                        setTimeout(() => { this.couponSuccess = ''; }, 4000);
                    }
                },

                async applyCoupon() {
                    if (!this.couponInput.trim()) return;
                    this.couponLoading = true;
                    this.couponError = '';
                    this.couponSuccess = '';

                    try {
                        const response = await fetch('<?php echo e(route("coupon.apply")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ coupon_code: this.couponInput.trim() }),
                        });

                        const data = await response.json();

                        if (data.errors) {
                            this.couponError = Object.values(data.errors).flat()[0];
                        } else if (data.success) {
                            this.couponCode = data.coupon_code;
                            this.discount = data.discount;
                            this.subtotal = data.summary.subtotal;
                            this.shipping = data.summary.shipping;
                            this.shippingLabel = data.summary.shipping === 0 ? 'Free' : '<?php echo e($currency_symbol); ?>' + Number(data.summary.shipping).toFixed(2);
                            this.total = data.summary.total;
                            this.couponSuccess = 'Coupon applied! You saved <?php echo e($currency_symbol); ?>' + Number(data.discount).toFixed(2) + '.';
                            this.couponInput = '';
                            setTimeout(() => { this.couponSuccess = ''; }, 4000);
                        }
                    } catch (e) {
                        this.couponError = 'Something went wrong. Please try again.';
                    } finally {
                        this.couponLoading = false;
                    }
                },

                async removeCoupon() {
                    this.couponLoading = true;
                    this.couponError = '';
                    this.couponSuccess = '';

                    try {
                        const response = await fetch('<?php echo e(route("coupon.remove")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({}),
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.couponCode = null;
                            this.discount = 0;
                            this.subtotal = data.summary.subtotal;
                            this.shipping = data.summary.shipping;
                            this.shippingLabel = data.summary.shipping === 0 ? 'Free' : '<?php echo e($currency_symbol); ?>' + Number(data.summary.shipping).toFixed(2);
                            this.total = data.summary.total;
                            this.couponSuccess = 'Coupon removed.';
                            setTimeout(() => { this.couponSuccess = ''; }, 4000);
                        }
                    } catch (e) {
                        this.couponError = 'Something went wrong. Please try again.';
                    } finally {
                        this.couponLoading = false;
                    }
                },
            };
        }

        function number_format(num, dec) {
            return Number(num).toFixed(dec || 2);
        }
    </script>
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
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views\checkout\index.blade.php ENDPATH**/ ?>