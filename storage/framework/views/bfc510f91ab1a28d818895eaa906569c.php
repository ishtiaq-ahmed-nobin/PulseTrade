<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? 'Admin'); ?> — PulseTrade</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-body antialiased bg-ivory text-navy-900" x-data="{ sidebarOpen: false }">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" x-cloak x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-navy-950/50 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-navy-950 shadow-[4px_0_24px_rgba(5,8,26,0.4)] flex flex-col transition-transform duration-300 lg:translate-x-0">

        <!-- Logo -->
        <div class="h-16 flex items-center gap-3 px-6 border-b border-white/10 shrink-0">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2">
                <svg width="28" height="20" viewBox="0 0 34 24">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-lg text-white tracking-tight">PulseTrade</span>
            </a>
            <span class="ml-2 text-[10px] font-semibold uppercase tracking-widest text-pulse-400 bg-pulse-500/15 px-2 py-0.5 rounded">Admin</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

            
            
            
            <?php
                $isActiveDashboard = request()->routeIs('admin.dashboard');
            ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors <?php echo e($isActiveDashboard ? 'bg-pulse-500/15 text-pulse-400' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>
                </svg>
                Dashboard
            </a>

            <div class="pt-2"></div>

            
            
            
            <?php $__currentLoopData = $navGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $groupActive = false;
                    foreach ($group['items'] as $item) {
                        $parts = explode('.', $item['route']);
                        $prefix = count($parts) >= 2 ? $parts[0] . '.' . $parts[1] : $item['route'];
                        if (request()->routeIs($item['route']) || request()->routeIs($prefix . '.*')) {
                            $groupActive = true;
                            break;
                        }
                    }
                ?>

                
                <div class="flex items-center justify-between gap-2 px-3 pt-4 pb-1">
                    <span class="text-[11px] font-semibold uppercase tracking-wider <?php echo e($groupActive ? 'text-pulse-400' : 'text-white/30'); ?>"><?php echo e($group['label']); ?></span>
                    <?php if(isset($group['badge']) && $group['badge'] > 0): ?>
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold rounded-full bg-red-500 text-white leading-none"><?php echo e($group['badge']); ?></span>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-0.5 pl-1">
                    <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $parts = explode('.', $item['route']);
                            $prefix = count($parts) >= 2 ? $parts[0] . '.' . $parts[1] : $item['route'];
                            $isActive = request()->routeIs($item['route']) ||
                                        ($item['route'] !== 'admin.dashboard' && request()->routeIs($prefix . '.*'));
                        ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors <?php echo e($isActive ? 'bg-pulse-500/15 text-pulse-400' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $item['icon']; ?></svg>
                            <span class="flex-1 text-left"><?php echo e($item['label']); ?></span>
                            <?php if(isset($item['badge']) && $item['badge'] > 0): ?>
                                <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold rounded-full <?php echo e($item['badge_color'] ?? 'bg-red-500 text-white'); ?>"><?php echo e($item['badge']); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </nav>

        <!-- Bottom section -->
        <div class="border-t border-white/10 p-3 shrink-0">
            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View Store
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <div class="lg:pl-64 min-h-screen flex flex-col">

        <!-- Top bar -->
        <header class="h-16 bg-navy-950 border-b border-white/10 shadow-[0_2px_16px_rgba(5,8,26,0.3)] flex items-center justify-between px-4 sm:px-6 shrink-0 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <?php if(isset($header)): ?>
                    <div>
                        <?php echo e($header); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-sm text-white/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-medium text-white"><?php echo e(auth()->user()->name); ?></span>
                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-sm text-white/70 hover:text-white transition-colors font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">

            <?php if(session('success')): ?>
                <div x-data="{ show: true }" x-show="show" x-cloak
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium"><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo e($slot); ?>

        </main>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\idb-project\PulseTrade\resources\views/components/layouts/admin.blade.php ENDPATH**/ ?>