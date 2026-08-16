<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Newsletter Subscribers</h1>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Subscribers</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Active</p>
            <p class="text-2xl font-display font-bold text-green-600 mt-1">{{ $active }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.subscribers.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search email or name..."
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
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Subscribed</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($subscribers as $subscriber)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-navy-900">{{ $subscriber->email }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $subscriber->name ?? '—' }}</td>
                            <td class="px-5 py-3">
                                @if($subscriber->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs">{{ $subscriber->subscribed_at?->format('M d, Y') ?? $subscriber->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <form method="POST" action="{{ route('admin.subscribers.toggle', $subscriber) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-amber-600 hover:text-amber-800 text-xs font-medium">{{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                                <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" class="inline" onsubmit="return confirm('Delete this subscriber?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-navy-700/40">No subscribers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscribers->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">{{ $subscribers->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
