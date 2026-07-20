<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.categories.index') }}" class="text-navy-700/60 hover:text-navy-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-display font-bold text-navy-900">Create Category</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white rounded-xl border border-navy-100 p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-navy-700 mb-1">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                       placeholder="e.g. Laptops & Computers">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-navy-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                          placeholder="Optional category description">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="parent_id" class="block text-sm font-medium text-navy-700 mb-1">Parent Category</label>
                <select name="parent_id" id="parent_id"
                        class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">None (Top Level)</option>
                    @foreach ($parentCategories as $cat)
                        <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-pulse-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                    Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
