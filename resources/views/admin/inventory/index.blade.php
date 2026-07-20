<x-layouts.admin>
    <x-slot name="header">
        <h1 class="text-xl font-display font-bold text-navy-900">Inventory</h1>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Products</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Total Stock</p>
            <p class="text-2xl font-display font-bold text-navy-900 mt-1">{{ $totalStock }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Low Stock (&lt;5)</p>
            <p class="text-2xl font-display font-bold text-amber-600 mt-1">{{ $lowStock }}</p>
        </div>
        <div class="bg-white rounded-xl border border-navy-100 p-5">
            <p class="text-sm font-medium text-navy-700/60">Out of Stock</p>
            <p class="text-2xl font-display font-bold text-red-600 mt-1">{{ $outOfStock }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.inventory.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                       class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-navy-700/60 mb-1">Stock Status</label>
                <select name="stock_status" class="w-full rounded-lg border-navy-200 text-navy-900 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                    <option value="">All</option>
                    <option value="in" {{ request('stock_status') === 'in' ? 'selected' : '' }}>In Stock</option>
                    <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="bg-navy-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-navy-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-navy-700/60 border-b border-navy-100">
                        <th class="px-5 py-3 font-medium">Product</th>
                        <th class="px-5 py-3 font-medium">Category</th>
                        <th class="px-5 py-3 font-medium">Price</th>
                        <th class="px-5 py-3 font-medium">Stock</th>
                        <th class="px-5 py-3 font-medium">Value</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($products as $product)
                        <tr class="hover:bg-ivory/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-navy-900">{{ $product->name }}</td>
                            <td class="px-5 py-3 text-navy-700 text-xs">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-navy-700">{{ $currency_symbol }}{{ number_format($product->price, 2) }}</td>
                            <td class="px-5 py-3">
                                @if($product->stock === 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Out of Stock</span>
                                @elseif($product->stock < 5)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">{{ $product->stock }} units</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">{{ $product->stock }} units</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-navy-700">{{ $currency_symbol }}{{ number_format($product->price * $product->stock, 2) }}</td>
                            <td class="px-5 py-3 text-right">
                                <div x-data="{ editing: false }">
                                    <button x-show="!editing" @click="editing = true" class="text-pulse-500 hover:text-pulse-400 text-xs font-medium">Update</button>
                                    <form x-show="editing" x-cloak method="POST" action="{{ route('admin.inventory.updateStock', $product) }}" class="inline-flex items-center gap-1">
                                        @csrf @method('PATCH')
                                        <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="w-16 rounded border-navy-200 text-sm focus:border-pulse-500 focus:ring-pulse-500">
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-xs font-medium">Save</button>
                                        <button type="button" @click="editing = false" class="text-navy-700/40 hover:text-navy-900 text-xs">Cancel</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-navy-700/40">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="px-5 py-3 border-t border-navy-100">{{ $products->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
