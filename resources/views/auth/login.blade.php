<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — PulseTrade</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-ivory text-navy-900 min-h-screen flex">

    {{-- Left brand panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-navy-950 text-white flex-col justify-between p-12">
        <div>
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight">PulseTrade</span>
            </a>
        </div>
        <div>
            <blockquote class="font-display text-2xl leading-snug max-w-md">
                &ldquo;Packaging alone felt premium — the earbuds sound even better than the site promised.&rdquo;
            </blockquote>
            <p class="mt-4 text-sm text-ivory/60">— Marcus T., Verified Buyer</p>
        </div>
        <p class="text-xs text-ivory/30">&copy; {{ date('Y') }} PulseTrade. All rights reserved.</p>
    </div>

    {{-- Right form panel --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-sm" x-data="{ tab: '{{ session('register_tab') ? 'register' : 'login' }}' }">

            {{-- Logo (mobile) --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2 lg:hidden mb-8 justify-center">
                <svg width="34" height="24" viewBox="0 0 34 24" class="pulse-line">
                    <path d="M0 12 H8 L12 2 L17 22 L21 12 H34" fill="none" stroke="#3D63FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-display font-bold text-xl tracking-tight">PulseTrade</span>
            </a>

            {{-- Tabs --}}
            <div class="flex border-b border-navy-100 mb-8">
                <button @click="tab = 'login'" class="pb-3 text-sm font-semibold transition-colors flex-1 text-center"
                    :class="tab === 'login' ? 'text-navy-900 border-b-2 border-pulse-500' : 'text-navy-700/50 hover:text-navy-700'">
                    Sign In
                </button>
                <button @click="tab = 'register'" class="pb-3 text-sm font-semibold transition-colors flex-1 text-center"
                    :class="tab === 'register' ? 'text-navy-900 border-b-2 border-pulse-500' : 'text-navy-700/50 hover:text-navy-700'">
                    Create Account
                </button>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- ============ LOGIN FORM ============ --}}
            <form x-show="tab === 'login'" method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="text-xs font-semibold text-navy-700/70">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="text-xs font-semibold text-navy-700/70">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-navy-100 text-pulse-500 focus:ring-pulse-500">
                        <span class="text-xs text-navy-700">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-pulse-500 hover:text-pulse-400">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3 transition-colors">
                    Sign In
                </button>

                {{-- Demo Credentials Helper --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-center justify-between pb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Demo Login</span>
                        <span class="rounded bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-700">User Role</span>
                    </div>

                    <div class="space-y-1 text-xs text-slate-600 font-mono">
                        <p><strong>Email:</strong> <span id="demo-email">user@pulsetrade.com</span></p>
                        <p><strong>Password:</strong> <span id="demo-password">password</span></p>
                    </div>

                    <button
                        type="button"
                        onclick="fillCredentials('user@pulsetrade.com', 'password')"
                        class="mt-3 w-full rounded bg-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-300 transition">
                        ⚡ Auto-fill Demo Credentials
                    </button>
                </div>
            </form>

            {{-- ============ REGISTER FORM ============ --}}
            <form x-show="tab === 'register'" method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="reg-name" class="text-xs font-semibold text-navy-700/70">Full Name</label>
                    <input id="reg-name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30"
                        placeholder="John Doe">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reg-email" class="text-xs font-semibold text-navy-700/70">Email</label>
                    <input id="reg-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500 placeholder:text-navy-700/30"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reg-password" class="text-xs font-semibold text-navy-700/70">Password</label>
                    <input id="reg-password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500"
                        placeholder="Min. 8 characters">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reg-password-confirm" class="text-xs font-semibold text-navy-700/70">Confirm Password</label>
                    <input id="reg-password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500"
                        placeholder="Repeat password">
                </div>

                <button type="submit" class="w-full rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm py-3 transition-colors">
                    Create Account
                </button>
            </form>

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
