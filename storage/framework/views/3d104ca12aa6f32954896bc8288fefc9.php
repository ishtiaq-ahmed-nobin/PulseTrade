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
        <h1 class="text-xl font-display font-bold text-navy-900">Settings</h1>
     <?php $__env->endSlot(); ?>

    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>

        <div class="space-y-6">
            <?php
                $quickSetupKeys = ['store_name', 'store_email', 'store_phone', 'store_currency', 'store_address'];
            ?>
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $filtered = $items->reject(fn ($s) => in_array($s->key, $quickSetupKeys)); ?>
                <?php if($filtered->count()): ?>
                <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-navy-100">
                        <h2 class="font-display font-semibold text-navy-900 capitalize"><?php echo e($group); ?> Settings</h2>
                    </div>
                    <div class="p-5 space-y-4">
                        <?php $__currentLoopData = $filtered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                                <label class="text-sm font-medium text-navy-700"><?php echo e(ucwords(str_replace('_', ' ', $setting->key))); ?></label>
                                <div class="sm:col-span-2">
                                    <?php if(str_contains($setting->key, 'description') || str_contains($setting->key, 'address')): ?>
                                        <textarea name="settings[<?php echo e($setting->key); ?>]" rows="2"
                                                  class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500"><?php echo e(old("settings.{$setting->key}", $setting->value)); ?></textarea>
                                    <?php else: ?>
                                        <input type="<?php echo e(str_contains($setting->key, 'email') ? 'email' : (str_contains($setting->key, 'phone') ? 'tel' : 'text')); ?>"
                                               name="settings[<?php echo e($setting->key); ?>]"
                                               value="<?php echo e(old("settings.{$setting->key}", $setting->value)); ?>"
                                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($settings->isEmpty()): ?>
                <div class="bg-white rounded-xl border border-navy-100 p-5">
                    <p class="text-sm text-navy-700/60">No settings configured yet. Add default settings below.</p>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h2 class="font-display font-semibold text-navy-900 mb-4">Quick Setup</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Name</label>
                        <input type="text" name="settings[store_name]" value="<?php echo e(\App\Models\Setting::get('store_name', 'PulseTrade')); ?>"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Email</label>
                        <input type="email" name="settings[store_email]" value="<?php echo e(\App\Models\Setting::get('store_email', '')); ?>"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Phone</label>
                        <input type="tel" name="settings[store_phone]" value="<?php echo e(\App\Models\Setting::get('store_phone', '')); ?>"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Currency</label>
                        <input type="text" name="settings[store_currency]" value="<?php echo e(\App\Models\Setting::get('store_currency', 'USD')); ?>"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Address</label>
                        <textarea name="settings[store_address]" rows="2"
                                  class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500"><?php echo e(\App\Models\Setting::get('store_address', '')); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-pulse-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-pulse-400 transition-colors">Save All Settings</button>
            </div>
        </div>
    </form>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>