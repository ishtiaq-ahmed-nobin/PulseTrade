<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        $activeCategory = null;

        if ($request->filled('category')) {
            $activeCategory = Category::where('slug', $request->category)->first();

            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        $products = $query->latest()->get();
        $categories = Category::withCount('products')->get();

        return view('shop.index', compact('products', 'categories', 'activeCategory'));
    }
}
