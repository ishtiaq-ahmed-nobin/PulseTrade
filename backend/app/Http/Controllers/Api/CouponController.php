<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validate(Request $request): JsonResponse
    {
        // coupon apply
        $validated = $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
            'subtotal' => ['required', 'numeric', 'min:0'],
        ]);

        $code = strtoupper(trim($validated['coupon_code']));
        $coupon = Coupon::where('code', $code)->first();
        $subtotal = (float) $validated['subtotal'];

        if (! $coupon) {
            return response()->json(['errors' => ['coupon_code' => ['Invalid coupon code.']]], 422);
        }

        if (! $coupon->isValid()) {
            $reason = 'This coupon is no longer active.';
            if ($coupon->expires_at && $coupon->expires_at->isPast()) {
                $reason = 'This coupon has expired.';
            } elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                $reason = 'This coupon has reached its usage limit.';
            }

            return response()->json(['errors' => ['coupon_code' => [$reason]]], 422);
        }

        if ($coupon->min_order > 0 && $subtotal < $coupon->min_order) {
            return response()->json([
                'errors' => ['coupon_code' => ['Minimum order of ' . number_format($coupon->min_order, 2) . ' required.']],
            ], 422);
        }

        $discount = $coupon->discountAmount($subtotal);
        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 100);
        $shippingCost = (float) Setting::get('shipping_cost', 9.99);
        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingCost;
        $total = max(0, $subtotal + $shipping - $discount);

        return response()->json([
            'success' => true,
            'coupon_code' => $coupon->code,
            'discount' => $discount,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'shipping_label' => $shipping === 0 ? 'Free' : number_format($shipping, 2),
                'discount' => $discount,
                'total' => $total,
                'coupon_code' => $coupon->code,
            ],
        ]);
    }
}
