<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Customers</h1>
    </x-slot>

    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name, email, phone..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">Search</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Phone</th>
                        <th class="px-5 py-3 font-medium">Orders</th>
                        <th class="px-5 py-3 font-medium">Spent</th>
                        <th class="px-5 py-3 font-medium">Joined</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-pulse-500/15 flex items-center justify-center text-pulse-500 text-xs font-bold">
                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-navy-900">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-navy-700">{{ $customer->email }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $customer->orders_count }}</td>
                            <td class="px-5 py-3 font-medium">{{ $currency_symbol }}{{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}</td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs">{{ $customer->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline" onsubmit="return confirm('Delete this customer?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-navy-700/40">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">{{ $customers->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
