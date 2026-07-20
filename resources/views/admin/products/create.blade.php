<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="text-navy-700/60 hover:text-navy-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-display font-bold text-navy-900">Add Product</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
              class="bg-white rounded-xl border border-navy-100 p-6 space-y-5" x-data="{ galleryCount: 0 }">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-navy-700 mb-1">Product Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                           placeholder="e.g. PulseBook Pro 16">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-navy-700 mb-1">Category *</label>
                    <select name="category_id" id="category_id" required
                            class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-navy-700 mb-1">Description *</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                          placeholder="Product description">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="price" class="block text-sm font-medium text-navy-700 mb-1">Price ({{ $currency_symbol }}) *</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sale_price" class="block text-sm font-medium text-navy-700 mb-1">Sale Price ({{ $currency_symbol }})</label>
                    <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                           placeholder="Optional">
                    @error('sale_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-navy-700 mb-1">Stock *</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-navy-700 mb-1">Main Image *</label>
                <div class="flex items-center gap-4">
                    <label for="image" class="cursor-pointer bg-ivory border-2 border-dashed border-navy-200 rounded-lg px-6 py-8 text-center hover:border-pulse-500 transition-colors flex-1">
                        <svg class="w-8 h-8 mx-auto text-navy-700/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-navy-700/60">Click to upload main image</p>
                        <p class="text-xs text-navy-700/40 mt-1">JPEG, PNG, WebP — Max 5MB</p>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" class="hidden"
                           x-ref="mainImage" @change="
                               let file = $refs.mainImage.files[0];
                               if(file) {
                                   let preview = $refs.mainPreview;
                                   preview.src = URL.createObjectURL(file);
                                   preview.classList.remove('hidden');
                                   $refs.mainPlaceholder.classList.add('hidden');
                               }
                           ">
                    <div class="w-24 h-24 rounded-lg overflow-hidden bg-ivory border border-navy-100 shrink-0">
                        <img x-ref="mainPreview" class="w-full h-full object-cover hidden">
                        <div x-ref="mainPlaceholder" class="w-full h-full flex items-center justify-center text-navy-700/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-navy-700 mb-1">Gallery Images</label>
                <div class="flex items-center gap-4">
                    <label class="cursor-pointer bg-ivory border-2 border-dashed border-navy-200 rounded-lg px-6 py-8 text-center hover:border-pulse-500 transition-colors flex-1">
                        <svg class="w-8 h-8 mx-auto text-navy-700/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-navy-700/60">Click to upload gallery images</p>
                        <p class="text-xs text-navy-700/40 mt-1">Multiple files — Max 5MB each</p>
                        <input type="file" name="images[]" accept="image/*" multiple class="hidden">
                    </label>
                </div>
                @error('images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="rounded border-navy-300 text-pulse-500 focus:ring-pulse-500">
                <label for="is_featured" class="text-sm font-medium text-navy-700">Featured product</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-pulse-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                    Create Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
