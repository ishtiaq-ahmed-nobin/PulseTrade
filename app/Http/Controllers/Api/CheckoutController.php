<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:50'],
            'payment_method' => ['required', 'in:card,cod'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
        ]);

        $items = $this->buildItems($validated['items']);

        if (count($items) === 0) {
            return response()->json(['errors' => ['items' => ['Your cart is empty.']]], 422);
        }

        [$couponCode, $discount] = $this->resolveCoupon($validated['coupon_code'] ?? null, $items['subtotal']);

        $order = DB::transaction(function () use ($request, $validated, $items, $couponCode, $discount) {
            $user = $request->user() ?: User::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'password' => Hash::make(Str::random(32)),
                    'role' => 'customer',
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]
            );

            if ($request->user()) {
                $user->update([
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->makeOrderNumber(),
                'status' => 'pending',
                'total_amount' => $items['total'],
                'shipping_address' => $validated['address'] . ', ' . $validated['city'] . ' ' . $validated['postal_code'],
                'shipping_phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'] === 'card' ? 'stripe' : 'cod',
                'payment_status' => $validated['payment_method'] === 'card' ? 'paid' : 'pending',
                'coupon_code' => $couponCode,
                'discount_amount' => $discount,
            ]);

            foreach ($items['rows'] as $row) {
                $order->items()->create([
                    'product_id' => $row['product']->id,
                    'quantity' => $row['qty'],
                    'price' => $row['product']->final_price,
                ]);

                $row['product']->decrement('stock', min($row['qty'], $row['product']->stock));
            }

            if ($couponCode) {
                Coupon::where('code', $couponCode)->increment('used_count');
            }

            return $order;
        });

        $order->load('items.product');

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully.',
            'order' => $order,
        ], 201);
    }

    private function buildItems(array $requestedItems): array
    {
        $rows = [];
        $subtotal = 0;

        foreach ($requestedItems as $entry) {
            $product = Product::find($entry['product_id']);

            if (! $product || (int) $product->stock <= 0) {
                continue;
            }

            $qty = min((int) $entry['quantity'], $product->stock);
            $lineTotal = $product->final_price * $qty;
            $subtotal += $lineTotal;

            $rows[] = [
                'product' => $product,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 100);
        $shippingCost = (float) Setting::get('shipping_cost', 9.99);
        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingCost;

        return [
            'rows' => $rows,
            'subtotal' => $subtotal,
            'shipping' => count($rows) ? $shipping : 0,
            'total' => count($rows) ? $subtotal + $shipping : 0,
        ];
    }

    private function resolveCoupon(?string $code, float $subtotal): array
    {
        if (! $code || $subtotal <= 0) {
            return [null, 0];
        }

        $coupon = Coupon::where('code', strtoupper(trim($code)))->first();

        if (! $coupon || ! $coupon->isValid()) {
            return [null, 0];
        }

        if ($coupon->min_order > 0 && $subtotal < $coupon->min_order) {
            return [null, 0];
        }

        return [$coupon->code, $coupon->discountAmount($subtotal)];
    }

    private function makeOrderNumber(): string
    {
        do {
            $number = 'PT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
