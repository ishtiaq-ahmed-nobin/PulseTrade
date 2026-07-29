<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Sign In — PulseTrade</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white min-h-screen flex items-center justify-center p-4">

    {{-- Centered Card --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 sm:p-10 text-navy-900">

        {{-- Branding --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-2">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight">PulseTrade</span>
            </a>
            <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-indigo-500">
                <span class="w-6 h-px bg-indigo-300"></span> Administration
            </span>
            <h1 class="font-display text-2xl font-bold mt-4">Admin Sign In</h1>
            <p class="text-sm text-slate-500 mt-1">Enter your credentials to access the admin panel.</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-4 text-sm text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        {{-- Admin Login Form --}}
        <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="text-xs font-semibold text-slate-600">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder:text-slate-400"
                    placeholder="admin@example.com">
                @error('email')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="text-xs font-semibold text-slate-600">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="••••••••">
                @error('password')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs text-slate-600">Remember me</span>
                </label>
                <a href="{{ url('/login') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                    User login →
                </a>
            </div>

            <button type="submit" class="w-full rounded-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-3 transition-colors">
                Sign In to Admin
            </button>
        </form>

        {{-- Demo Credentials Helper --}}
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
