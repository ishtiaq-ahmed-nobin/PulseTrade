<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Reviews</h1>
    </x-slot>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Product</th>
                        <th class="px-5 py-3 font-medium">User</th>
                        <th class="px-5 py-3 font-medium">Rating</th>
                        <th class="px-5 py-3 font-medium">Comment</th>
                        <th class="px-5 py-3 font-medium">Date</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($reviews as $review)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3">
                                <p class="font-medium text-navy-900">{{ $review->product->name ?? 'Deleted' }}</p>
                            </td>
                            <td class="px-5 py-3 text-navy-700">{{ $review->user->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-navy-200' }}"
                                             fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                    <span class="text-xs text-navy-700/60 ml-1">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-navy-700 max-w-xs truncate">{{ $review->comment ?? '—' }}</td>
                            <td class="px-5 py-3 text-navy-700/60 text-xs">{{ $review->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No reviews yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
