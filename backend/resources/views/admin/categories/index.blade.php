<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-display font-bold text-navy-900">Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-pulse-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Category
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Slug</th>
                        <th class="px-5 py-3 font-medium">Parent</th>
                        <th class="px-5 py-3 font-medium">Products</th>
                        <th class="px-5 py-3 font-medium">Children</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-navy-900">{{ $category->name }}</td>
                            <td class="px-5 py-3 text-navy-700/60 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="px-5 py-3 text-navy-700/60">{{ $category->parent?->name ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-navy-50 text-navy-700">
                                    {{ $category->products_count }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                @if($category->children->count())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($category->children as $child)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-pulse-100 text-pulse-500">
                                                {{ $child->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-navy-700/30">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Products in it will be orphaned.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @if($category->children->count())
                            @foreach($category->children as $child)
                                <tr class="hover:bg-ivory/50 transition-colors bg-ivory/30">
                                    <td class="px-5 py-3 pl-10 font-medium text-navy-900">
                                        <span class="text-navy-700/30 mr-2">└</span>{{ $child->name }}
                                    </td>
                                    <td class="px-5 py-3 text-navy-700/60 font-mono text-xs">{{ $child->slug }}</td>
                                    <td class="px-5 py-3 text-navy-700/60">{{ $category->name }}</td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-navy-50 text-navy-700">
                                            {{ $child->products_count ?? $child->products()->count() }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">—</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $child) }}" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Edit</a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $child) }}" onsubmit="return confirm('Delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No categories yet</p>
                                <a href="{{ route('admin.categories.create') }}" class="text-pulse-500 hover:text-pulse-400 text-sm font-medium">Create your first category</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
