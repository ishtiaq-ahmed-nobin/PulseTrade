<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="text-navy-700/60 hover:text-navy-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-display font-bold text-navy-900">Edit Product</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
              class="bg-white rounded-xl border border-navy-100 p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-navy-700 mb-1">Product Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-navy-700 mb-1">Category *</label>
                    <select name="category_id" id="category_id" required
                            class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
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
                          class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="price" class="block text-sm font-medium text-navy-700 mb-1">Price ({{ $currency_symbol }}) *</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sale_price" class="block text-sm font-medium text-navy-700 mb-1">Sale Price ({{ $currency_symbol }})</label>
                    <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    @error('sale_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-navy-700 mb-1">Stock *</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-navy-700 mb-1">Main Image</label>
                <div class="flex items-center gap-4">
                    <label for="image" class="cursor-pointer bg-ivory border-2 border-dashed border-navy-200 rounded-lg px-6 py-8 text-center hover:border-pulse-500 transition-colors flex-1">
                        <svg class="w-8 h-8 mx-auto text-navy-700/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-navy-700/60">Click to replace main image</p>
                        <p class="text-xs text-navy-700/40 mt-1">Leave empty to keep current image</p>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                    <div class="w-24 h-24 rounded-lg overflow-hidden bg-ivory border border-navy-100 shrink-0">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover"
                             onerror="this.onerror=null;this.src='{{ \App\Models\Product::fallbackImageUrl() }}';">
                    </div>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <div class="mt-3">
                    <label for="image_url" class="block text-sm font-medium text-navy-700 mb-1">Or Image URL</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url', str_starts_with((string) $product->image, 'http') ? $product->image : '') }}"
                           class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                           placeholder="https://images.unsplash.com/...">
                    <p class="text-xs text-navy-700/40 mt-1">Uploading a file or entering a URL replaces the current main image.</p>
                    @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            @if(count($product->gallery_images))
                <div>
                    <label class="block text-sm font-medium text-navy-700 mb-1">Current Gallery</label>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($product->gallery_images as $img)
                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-navy-100">
                                <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover"
                                     onerror="this.onerror=null;this.src='{{ \App\Models\Product::fallbackImageUrl() }}';">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-navy-700 mb-1">Upload New Gallery Images</label>
                <label class="cursor-pointer bg-ivory border-2 border-dashed border-navy-200 rounded-lg px-6 py-6 text-center hover:border-pulse-500 transition-colors block">
                    <svg class="w-6 h-6 mx-auto text-navy-700/30 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-navy-700/60">Replace all gallery images (upload new set)</p>
                    <input type="file" name="images[]" accept="image/*" multiple class="hidden">
                </label>
                @error('images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <div class="mt-3 space-y-2">
                    <label class="block text-sm font-medium text-navy-700">Add Gallery Image URLs</label>
                    @for ($i = 0; $i < 3; $i++)
                        <input type="url" name="gallery_urls[]" value="{{ old('gallery_urls.'.$i) }}"
                               class="w-full rounded-lg border-navy-200 text-navy-900 focus:border-pulse-500 focus:ring-pulse-500"
                               placeholder="https://images.unsplash.com/...">
                    @endfor
                    @error('gallery_urls.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                       class="rounded border-navy-300 text-pulse-500 focus:ring-pulse-500">
                <label for="is_featured" class="text-sm font-medium text-navy-700">Featured product</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-pulse-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
