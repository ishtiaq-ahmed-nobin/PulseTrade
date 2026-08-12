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
<body class="font-body antialiased bg-navy-950 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        
        <div class="flex justify-center mb-6">
            <svg width="40" height="28" viewBox="0 0 40 28" class="pulse-line">
                <path d="M0 14 H10 L15 2 L20 26 L25 14 H40" fill="none" stroke="#3D63FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        
        <div class="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">

            
            <div class="text-center mb-8">
                <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-pulse-500">
                    <span class="w-6 h-px bg-pulse-300"></span> Administration
                </span>
                <h1 class="font-display text-2xl font-bold text-navy-900 mt-4">Admin Sign In</h1>
                <p class="text-sm text-navy-700/50 mt-1">Enter your credentials to access the admin panel.</p>
            </div>

            
            <?php if(session('status')): ?>
                <div class="mb-4 text-sm text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            
            <?php if($errors->any()): ?>
                <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('admin.login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="text-xs font-semibold text-navy-700/70">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30"
                        placeholder="admin@example.com">
                </div>

                <div>
                    <label for="password" class="text-xs font-semibold text-navy-700/70">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-navy-100 text-pulse-500 focus:ring-pulse-500">
                        <span class="text-xs text-navy-700">Remember me</span>
                    </label>
                    <a href="<?php echo e(route('login')); ?>" class="text-xs font-semibold text-pulse-500 hover:text-pulse-400">
                        User login &rarr;
                    </a>
                </div>

                <button type="submit" class="w-full rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3 transition-colors">
                    Sign In to Admin
                </button>
            </form>

            
            <div class="mt-6 rounded-xl border border-pulse-100 bg-pulse-100/20 p-4">
                <div class="flex items-center justify-between pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-pulse-500">Demo Login</span>
                    <span class="rounded bg-pulse-100 px-2 py-0.5 text-xs font-medium text-pulse-500">Admin Role</span>
                </div>

                <div class="space-y-1 text-xs text-navy-700 font-mono">
                    <p><strong>Email:</strong> <span id="demo-email">admin@pulsetrade.com</span></p>
                    <p><strong>Password:</strong> <span id="demo-password">password</span></p>
                </div>

                <button
                    type="button"
                    onclick="fillCredentials('admin@pulsetrade.com', 'password')"
                    class="mt-3 w-full rounded-lg bg-pulse-100 px-3 py-1.5 text-xs font-semibold text-pulse-500 hover:bg-pulse-300 transition">
                    &#9889; Auto-fill Demo Credentials
                </button>
            </div>

        </div>

        
        <p class="text-center mt-8 text-xs text-navy-700/40">
            &copy; <?php echo e(date('Y')); ?> PulseTrade. All rights reserved.
        </p>
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
<?php /**PATH E:\xampp\htdocs\idb-project\PulseTrade\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>