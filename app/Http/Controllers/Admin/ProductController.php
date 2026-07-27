<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock', '<', 5);
            } elseif ($request->stock === 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|url|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $existing = Product::where('slug', $validated['slug'])->first();
        if ($existing) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        // Main image: file upload takes priority, then URL
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        // Gallery: merge file uploads and URL entries
        $galleryPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $galleryPaths[] = $image->store('products', 'public');
            }
        }
        if (!empty($validated['gallery_urls'])) {
            foreach ($validated['gallery_urls'] as $url) {
                if (!empty($url)) {
                    $galleryPaths[] = $url;
                }
            }
        }
        unset($validated['gallery_urls']);
        $validated['images'] = count($galleryPaths) > 0 ? $galleryPaths : null;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|url|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['name']);
        $existing = Product::where('slug', $slug)->where('id', '!=', $product->id)->first();
        $validated['slug'] = $existing ? $slug . '-' . time() : $slug;

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($this->isStoredImage($product->image) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            if ($this->isStoredImage($product->image) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        if ($request->hasFile('images')) {
            if (count($product->gallery_images) > 0) {
                foreach ($product->gallery_images as $oldImage) {
                    if ($this->isStoredImage($oldImage) && Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $galleryPaths = [];
            foreach ($request->file('images') as $image) {
                $galleryPaths[] = $image->store('products', 'public');
            }
            $validated['images'] = $galleryPaths;
        }
        if (!empty($validated['gallery_urls'])) {
            $galleryPaths = $validated['images'] ?? $product->gallery_images;
            foreach ($validated['gallery_urls'] as $url) {
                if (!empty($url)) {
                    $galleryPaths[] = $url;
                }
            }
            $validated['images'] = count($galleryPaths) > 0 ? $galleryPaths : null;
        }
        unset($validated['gallery_urls']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($this->isStoredImage($product->image) && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        if (count($product->gallery_images) > 0) {
            foreach ($product->gallery_images as $image) {
                if ($this->isStoredImage($image) && Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->reviews()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function isStoredImage(?string $path): bool
    {
        return filled($path) && ! str_starts_with($path, 'http://') && ! str_starts_with($path, 'https://');
    }
}
