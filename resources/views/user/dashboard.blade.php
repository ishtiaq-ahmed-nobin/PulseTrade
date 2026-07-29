@php
    $statusBadges = [
        'pending' => 'bg-amber-100 text-amber-800',
        'processing' => 'bg-blue-100 text-blue-800',
        'shipped' => 'bg-indigo-100 text-indigo-800',
        'completed' => 'bg-emerald-100 text-emerald-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ];
@endphp

<x-storefront-layout :title="'My Account — PulseTrade'">

    <div class="bg-navy-950 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-semibold tracking-widest uppercase text-pulse-300">Account</span>
            <h1 class="font-display text-3xl sm:text-4xl font-bold mt-2">My Dashboard</h1>
            <p class="text-ivory/60 mt-2 text-sm">Welcome back, {{ $user->name }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[320px_1fr] gap-10">

        {{-- Sidebar --}}
        <aside class="space-y-6">
            <div class="rounded-2xl bg-white border border-navy-100 p-6 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-pulse-100 flex items-center justify-center">
                    <span class="font-display font-bold text-xl text-pulse-600">{{ substr($user->name, 0, 2) }}</span>
                </div>
                <p class="font-semibold text-navy-900 mt-3">{{ $user->name }}</p>
                <p class="text-xs text-navy-700/50 mt-0.5">{{ $user->email }}</p>
            </div>

            <nav class="rounded-2xl bg-white border border-navy-100 divide-y divide-navy-50 text-sm">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-5 py-3.5 text-pulse-600 font-semibold bg-pulse-50/50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    My Profile
                </a>
                <a href="#orders" class="flex items-center gap-3 px-5 py-3.5 text-navy-700 hover:text-pulse-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Order History
                </a>
                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-navy-700 hover:text-pulse-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Continue Shopping
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-2xl border border-red-200 text-red-600 hover:bg-red-50 font-semibold text-sm py-3.5 transition-colors">
                    Sign Out
                </button>
            </form>
        </aside>

        {{-- Main Content --}}
        <div class="space-y-10">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-5 py-3.5">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Profile Overview --}}
            <section>
                <h2 class="font-display text-xl font-bold text-navy-900 mb-4">Profile Information</h2>
                <div class="rounded-2xl bg-white border border-navy-100 p-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-navy-700/50 uppercase">Name</p>
                            <p class="text-sm font-semibold text-navy-900 mt-1">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-navy-700/50 uppercase">Email</p>
                            <p class="text-sm text-navy-900 mt-1">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-navy-700/50 uppercase">Phone</p>
                            <p class="text-sm text-navy-900 mt-1">{{ $user->phone ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-navy-700/50 uppercase">Shipping Address</p>
                            <p class="text-sm text-navy-900 mt-1">{{ $user->address ?? '—' }}</p>
                        </div>
                    </div>

                    <button @click="$el.nextElementSibling.classList.toggle('hidden')" class="mt-6 text-sm font-semibold text-pulse-500 hover:text-pulse-400 transition-colors">
                        Edit Profile →
                    </button>

                    {{-- Edit form --}}
                    <form method="POST" action="{{ route('user.profile.update') }}" class="hidden mt-6 pt-6 border-t border-navy-100 space-y-4">
                        @csrf
                        <div>
                            <label class="text-xs font-semibold text-navy-700/70">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-navy-700/70">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-navy-700/70">Shipping Address</label>
                            <textarea name="address" rows="2" class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">{{ old('address', $user->address) }}</textarea>
                            @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm px-6 py-2.5 transition-colors">
                            Save Changes
                        </button>
                    </form>
                </div>
            </section>

            {{-- Change Password --}}
            <section>
                <h2 class="font-display text-xl font-bold text-navy-900 mb-4">Change Password</h2>
                <div class="rounded-2xl bg-white border border-navy-100 p-6">
                    <form method="POST" action="{{ route('user.password.update') }}" class="space-y-4 max-w-md">
                        @csrf
                        <div>
                            <label class="text-xs font-semibold text-navy-700/70">Current Password</label>
                            <input type="password" name="current_password" required
                                class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-navy-700/70">New Password</label>
                            <input type="password" name="password" required
                                class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                            @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-navy-700/70">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required
                                class="mt-1 w-full rounded-xl border-navy-100 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        </div>
                        <button type="submit" class="rounded-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-sm px-6 py-2.5 transition-colors">
                            Update Password
                        </button>
                    </form>
                </div>
            </section>

            {{-- Order History --}}
            <section id="orders">
                <h2 class="font-display text-xl font-bold text-navy-900 mb-4">Order History</h2>

                @if ($orders->isEmpty())
                    <div class="rounded-2xl bg-white border border-navy-100 p-12 text-center">
                        <p class="text-navy-700/50 text-sm">You haven't placed any orders yet.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-4 text-sm font-semibold text-pulse-500 hover:text-pulse-400">Start shopping →</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($orders as $order)
                            <div class="rounded-2xl bg-white border border-navy-100 p-5">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-navy-900">{{ $order->order_number }}</p>
                                        <p class="text-xs text-navy-700/50 mt-0.5">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs px-3 py-1 rounded-full font-semibold {{ $statusBadges[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <span class="text-sm font-bold text-navy-900">{{ $currency_symbol }}{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                                @if ($order->items->count())
                                    <div class="mt-3 pt-3 border-t border-navy-50 flex flex-wrap gap-3">
                                        @foreach ($order->items as $item)
                                            <span class="text-xs text-navy-700/60 bg-ivory px-2.5 py-1 rounded-full">
                                                {{ $item->product?->name ?? 'Product' }} × {{ $item->quantity }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-storefront-layout>
