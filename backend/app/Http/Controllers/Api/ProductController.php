<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home(): JsonResponse
    {
        $featured = Product::where('is_featured', true)->with('category')->limit(8)->get();
        $bestSellers = Product::withCount('reviews')->with('category')
            ->orderByDesc('reviews_count')
            ->limit(4)
            ->get();
        $newArrivals = Product::latest()->with('category')->limit(8)->get();
        $categories = Category::withCount('products')->get();

        return response()->json([
            'featured' => $featured,
            'best_sellers' => $bestSellers,
            'new_arrivals' => $newArrivals,
            'categories' => $categories,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category')->withCount('reviews');

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->filled('min_price')) {
            $query->where(function ($w) use ($request) {
                $w->where('price', '>=', (float) $request->min_price)
                    ->orWhere('sale_price', '>=', (float) $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->where(function ($w) use ($request) {
                $w->where('price', '<=', (float) $request->max_price)
                    ->orWhere('sale_price', '<=', (float) $request->max_price);
            });
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'rating':
                $query->orderByDesc('reviews_count');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('category', 'reviews.user');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->limit(4)
            ->get();

        $averageRating = round((float) $product->averageRating(), 1);

        return response()->json([
            'product' => $product,
            'gallery' => $product->gallery_urls,
            'reviews' => $product->reviews,
            'average_rating' => $averageRating,
            'review_count' => $product->reviews->count(),
            'related' => $related,
        ]);
    }
}
