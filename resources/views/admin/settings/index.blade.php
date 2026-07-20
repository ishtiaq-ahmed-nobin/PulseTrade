<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Settings</h1>
    </x-slot>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PATCH')

        <div class="space-y-6">
            @php
                $quickSetupKeys = ['store_name', 'store_email', 'store_phone', 'store_currency', 'store_address'];
            @endphp
            @foreach ($settings as $group => $items)
                @php $filtered = $items->reject(fn ($s) => in_array($s->key, $quickSetupKeys)); @endphp
                @if ($filtered->count())
                <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-navy-100">
                        <h2 class="font-display font-semibold text-navy-900 capitalize">{{ $group }} Settings</h2>
                    </div>
                    <div class="p-5 space-y-4">
                        @foreach ($filtered as $setting)
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                                <label class="text-sm font-medium text-navy-700">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                                <div class="sm:col-span-2">
                                    @if(str_contains($setting->key, 'description') || str_contains($setting->key, 'address'))
                                        <textarea name="settings[{{ $setting->key }}]" rows="2"
                                                  class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">{{ old("settings.{$setting->key}", $setting->value) }}</textarea>
                                    @else
                                        <input type="{{ str_contains($setting->key, 'email') ? 'email' : (str_contains($setting->key, 'phone') ? 'tel' : 'text') }}"
                                               name="settings[{{ $setting->key }}]"
                                               value="{{ old("settings.{$setting->key}", $setting->value) }}"
                                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach

            @if ($settings->isEmpty())
                <div class="bg-white rounded-xl border border-navy-100 p-5">
                    <p class="text-sm text-navy-700/60">No settings configured yet. Add default settings below.</p>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-navy-100 p-5">
                <h2 class="font-display font-semibold text-navy-900 mb-4">Quick Setup</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Name</label>
                        <input type="text" name="settings[store_name]" value="{{ \App\Models\Setting::get('store_name', 'PulseTrade') }}"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Email</label>
                        <input type="email" name="settings[store_email]" value="{{ \App\Models\Setting::get('store_email', '') }}"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Phone</label>
                        <input type="tel" name="settings[store_phone]" value="{{ \App\Models\Setting::get('store_phone', '') }}"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Currency</label>
                        <input type="text" name="settings[store_currency]" value="{{ \App\Models\Setting::get('store_currency', 'USD') }}"
                               class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-navy-700/60 mb-1">Store Address</label>
                        <textarea name="settings[store_address]" rows="2"
                                  class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">{{ \App\Models\Setting::get('store_address', '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-pulse-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-pulse-400 transition-colors">Save All Settings</button>
            </div>
        </div>
    </form>
</x-layouts.admin>
