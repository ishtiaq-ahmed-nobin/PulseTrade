<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin Sign In — PulseTrade</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-body antialiased bg-ivory text-navy-900 min-h-screen flex">

    
    <div class="hidden lg:flex lg:w-1/2 bg-navy-950 text-white flex-col justify-between p-12">
        <div>
            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight">PulseTrade</span>
            </a>
        </div>
        <div>
            <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-pulse-300 mb-4">
                <span class="w-6 h-px bg-pulse-300"></span> Administration
            </span>
            <h1 class="font-display text-3xl font-bold leading-snug">Admin Portal</h1>
            <p class="mt-3 text-ivory/60 text-sm max-w-sm">Manage products, orders, customers, and store settings from a single dashboard.</p>
        </div>
        <p class="text-xs text-ivory/30">&copy; <?php echo e(date('Y')); ?> PulseTrade. All rights reserved.</p>
    </div>

    
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-sm">

            
            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2 lg:hidden mb-8 justify-center">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight">PulseTrade</span>
            </a>

            <h2 class="font-display text-2xl font-bold text-navy-900">Admin Sign In</h2>
            <p class="text-sm text-navy-700/50 mt-1">Enter your credentials to access the admin panel.</p>

            
            <?php if(session('status')): ?>
                <div class="mt-4 text-sm text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('admin.login')); ?>" class="mt-8 space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="text-xs font-semibold text-navy-700/70">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30"
                        placeholder="admin@example.com">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 mt-1.5"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="password" class="text-xs font-semibold text-navy-700/70">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500"
                        placeholder="••••••••">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 mt-1.5"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-navy-100 text-pulse-500 focus:ring-pulse-500">
                        <span class="text-xs text-navy-700">Remember me</span>
                    </label>
                    <a href="<?php echo e(url('/login')); ?>" class="text-xs font-semibold text-pulse-500 hover:text-pulse-400">
                        User login →
                    </a>
                </div>

                <button type="submit" class="w-full rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3 transition-colors">
                    Sign In to Admin
                </button>
            </form>

            
            <div class="mt-6 rounded-xl border border-indigo-100 bg-indigo-50 p-4">
                <div class="flex items-center justify-between pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Demo Login</span>
                    <span class="rounded bg-indigo-200/70 px-2 py-0.5 text-xs font-medium text-indigo-800">Admin Role</span>
                </div>

                <div class="space-y-1 text-xs text-indigo-800 font-mono">
                    <p><strong>Email:</strong> <span id="demo-email">admin@pulsetrade.com</span></p>
                    <p><strong>Password:</strong> <span id="demo-password">password</span></p>
                </div>

                <button
                    type="button"
                    onclick="fillCredentials('admin@pulsetrade.com', 'password')"
                    class="mt-3 w-full rounded-lg bg-indigo-200/80 px-3 py-1.5 text-xs font-semibold text-indigo-800 hover:bg-indigo-200 transition">
                    ⚡ Auto-fill Demo Credentials
                </button>
            </div>

        </div>
    </div>

    <script>
    function fillCredentials(email, password) {
        var emailInput = document.querySelector('input[type="email"]');
        var passwordInput = document.querySelector('input[type="password"]');
        if (emailInput) emailInput.value = email;
        if (passwordInput) passwordInput.value = password;
    }
    </script>

</body>
</html>
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>