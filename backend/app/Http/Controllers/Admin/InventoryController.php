<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($search = $request->input('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->input('stock_status') === 'low') {
            $query->where('stock', '<', 5);
        } elseif ($request->input('stock_status') === 'out') {
            $query->where('stock', 0);
        } elseif ($request->input('stock_status') === 'in') {
            $query->where('stock', '>', 0);
        }

        $products = $query->orderBy('stock')->paginate(15)->withQueryString();

        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStock = Product::where('stock', '<', 5)->where('stock', '>', 0)->count();
        $outOfStock = Product::where('stock', 0)->count();
        $totalValue = Product::selectRaw('SUM(price * stock)')->value('total') ?? 0;

        return view('admin.inventory.index', compact(
            'products', 'totalProducts', 'totalStock', 'lowStock', 'outOfStock', 'totalValue'
        ));
    }

    public function updateStock(Product $product, Request $request)
    {
        $request->validate(['stock' => 'required|integer|min:0']);
        $product->update(['stock' => $request->input('stock')]);
        return back()->with('success', 'Stock updated for ' . $product->name);
    }
}
