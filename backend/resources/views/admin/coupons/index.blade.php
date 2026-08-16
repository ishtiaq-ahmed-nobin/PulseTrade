<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Coupons</h1>
    </x-slot>

    <div class="bg-white rounded-xl border border-navy-100 p-5 mb-6" x-data="{ showForm: false }">
        <button @click="showForm = !showForm" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">
            <span x-text="showForm ? 'Cancel' : '+ New Coupon'"></span>
        </button>

        <div x-show="showForm" x-cloak x-transition class="mt-4">
            <form method="POST" action="{{ route('admin.coupons.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Code</label>
                    <input type="text" name="code" required placeholder="e.g. SAVE20"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Type</label>
                    <select name="type" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed ({{ $currency_symbol }})</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Value</label>
                    <input type="number" name="value" required step="0.01" min="0" placeholder="20"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Min Order ({{ $currency_symbol }})</label>
                    <input type="number" name="min_order" step="0.01" min="0" placeholder="0"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Usage Limit</label>
                    <input type="number" name="usage_limit" min="1" placeholder="Unlimited"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-navy-700/60 mb-1">Expires At</label>
                    <input type="datetime-local" name="expires_at"
                           class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <button type="submit" class="bg-pulse-500 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-pulse-400 transition-colors">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Code</th>
                        <th class="px-5 py-3 font-medium">Type</th>
                        <th class="px-5 py-3 font-medium">Value</th>
                        <th class="px-5 py-3 font-medium">Min Order</th>
                        <th class="px-5 py-3 font-medium">Used</th>
                        <th class="px-5 py-3 font-medium">Expires</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($coupons as $coupon)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-mono font-medium text-navy-900">{{ $coupon->code }}</td>
                            <td class="px-5 py-3 text-navy-700 text-xs">{{ $coupon->type === 'percentage' ? 'Percentage' : 'Fixed' }}</td>
                            <td class="px-5 py-3 text-navy-900">{{ $coupon->type === 'percentage' ? $coupon->value . '%' : $currency_symbol . number_format($coupon->value, 2) }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $coupon->min_order > 0 ? $currency_symbol . number_format($coupon->min_order, 2) : '—' }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}</td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs">{{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}</td>
                            <td class="px-5 py-3">
                                @if($coupon->isValid())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <form method="POST" action="{{ route('admin.coupons.toggle', $coupon) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-amber-600 hover:text-amber-800 text-xs font-medium">{{ $coupon->is_active ? 'Disable' : 'Enable' }}</button>
                                </form>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="inline" onsubmit="return confirm('Delete this coupon?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-navy-700/40">No coupons yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">{{ $coupons->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
