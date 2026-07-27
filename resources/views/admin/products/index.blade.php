<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-display font-bold text-navy-900">Products</h1>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-pulse-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-pulse-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Product
            </a>
        </div>
    </x-slot>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div class="min-w-[160px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Category</label>
                <select name="category" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Stock</label>
                <select name="stock" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All</option>
                    <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock (&lt;5)</option>
                    <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['q', 'category', 'stock']))
                <a href="{{ route('admin.products.index') }}" class="text-sm text-navy-700/60 hover:text-navy-900 font-medium">Clear</a>
            @endif
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Product</th>
                        <th class="px-5 py-3 font-medium">Category</th>
                        <th class="px-5 py-3 font-medium">Price</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Featured</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($products as $product)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-ivory rounded-lg overflow-hidden shrink-0">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover"
                                             onerror="this.onerror=null;this.src='{{ \App\Models\Product::fallbackImageUrl() }}';">
                                    </div>
                                    <div>
                                        <p class="font-medium text-navy-900">{{ $product->name }}</p>
                                        <p class="text-xs text-navy-700/50 font-mono">{{ $product->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-navy-700">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3">
                                @if($product->hasDiscount())
                                    <span class="text-navy-700/40 line-through text-xs">{{ $currency_symbol }}{{ number_format($product->price, 2) }}</span>
                                    <span class="text-red-600 font-medium ml-1">{{ $currency_symbol }}{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="font-medium">{{ $currency_symbol }}{{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                @if($product->stock === 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Out of Stock</span>
                                @elseif($product->stock < 5)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">{{ $product->stock }} left</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                @if($product->is_featured)
                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @else
                                    <span class="text-navy-700/30">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">
                                <p class="text-lg mb-2">No products found</p>
                                <a href="{{ route('admin.products.create') }}" class="text-pulse-500 hover:text-pulse-400 text-sm font-medium">Add your first product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
