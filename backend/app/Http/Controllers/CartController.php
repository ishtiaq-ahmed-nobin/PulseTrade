<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $qty) {
            $product = Product::with('category')->find($productId);
            if ($product) {
                $lineTotal = $product->final_price * $qty;
                $subtotal += $lineTotal;
                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'line_total' => $lineTotal,
                ];
            }
        }

        $freeShippingThreshold = (float) \App\Models\Setting::get('free_shipping_threshold', 150);
        $shippingCost = (float) \App\Models\Setting::get('shipping_cost', 12);
        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingCost;
        $total = $subtotal + $shipping;

        return view('cart.index', compact('items', 'subtotal', 'shipping', 'total', 'freeShippingThreshold'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $productId = (string) $request->product_id;
        $qty = (int) $request->qty;

        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;

        Session::put('cart', $cart);

        return back()
            ->with('success', 'Product added to cart.')
            ->with('open_cart', true);
    }

    public function update(Request $request, string $productId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $cart[$productId] = (int) $request->qty;

        Session::put('cart', $cart);

        return back()
            ->with('success', 'Cart updated.')
            ->with('open_cart', true);
    }

    public function destroy(string $productId)
    {
        $cart = Session::get('cart', []);
        unset($cart[$productId]);

        Session::put('cart', $cart);

        return back()
            ->with('success', 'Item removed from cart.')
            ->with('open_cart', true);
    }
}
