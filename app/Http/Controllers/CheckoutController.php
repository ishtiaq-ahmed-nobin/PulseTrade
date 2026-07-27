<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $checkout = $this->cartSummary();

        if (count($checkout['items']) === 0) {
            return redirect()->route('cart.index')->with('open_cart', true);
        }

        return view('checkout.index', $checkout);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'payment_method' => 'required|in:card,cod',
        ]);

        $checkout = $this->cartSummary();

        if (count($checkout['items']) === 0) {
            return redirect()->route('cart.index')->with('open_cart', true);
        }

        $order = DB::transaction(function () use ($validated, $checkout) {
            $user = auth()->user() ?: User::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'password' => Hash::make(Str::random(32)),
                    'role' => 'customer',
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]
            );

            if (auth()->check()) {
                $user->update([
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->makeOrderNumber(),
                'status' => 'pending',
                'total_amount' => $checkout['total'],
                'shipping_address' => $validated['address'] . ', ' . $validated['city'] . ' ' . $validated['postal_code'],
                'shipping_phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'] === 'card' ? 'stripe' : 'cod',
                'payment_status' => $validated['payment_method'] === 'card' ? 'paid' : 'pending',
            ]);

            foreach ($checkout['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['qty'],
                    'price' => $item['product']->final_price,
                ]);

                $item['product']->decrement('stock', min($item['qty'], $item['product']->stock));
            }

            return $order;
        });

        Session::forget('cart');
        Session::put('last_order_id', $order->id);

        return redirect()->route('checkout.confirmation');
    }

    public function confirmation()
    {
        $order = Order::with('items.product')->find(Session::get('last_order_id'));

        return view('checkout.confirmation', compact('order'));
    }

    private function cartSummary(): array
    {
        $cart = Session::get('cart', []);
        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            $qty = (int) $qty;
            $lineTotal = $product->final_price * $qty;
            $subtotal += $lineTotal;

            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 150);
        $shippingCost = (float) Setting::get('shipping_cost', 12);
        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingCost;

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => count($items) ? $shipping : 0,
            'total' => $subtotal + (count($items) ? $shipping : 0),
            'freeShippingThreshold' => $freeShippingThreshold,
        ];
    }

    private function makeOrderNumber(): string
    {
        do {
            $number = 'PT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
