<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->coupon_code));
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon) {
            return $this->respond($request, ['errors' => ['coupon_code' => ['Invalid coupon code.']]]);
        }

        if (! $coupon->isValid()) {
            $reason = 'This coupon is no longer active.';
            if ($coupon->expires_at && $coupon->expires_at->isPast()) {
                $reason = 'This coupon has expired.';
            } elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                $reason = 'This coupon has reached its usage limit.';
            }
            return $this->respond($request, ['errors' => ['coupon_code' => [$reason]]]);
        }

        $cart = Session::get('cart', []);
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $subtotal += $product->final_price * (int) $qty;
            }
        }

        if ($coupon->min_order > 0 && $subtotal < $coupon->min_order) {
            return $this->respond($request, [
                'errors' => ['coupon_code' => ['Minimum order of ' . number_format($coupon->min_order, 2) . ' required.']],
            ]);
        }

        $discount = $coupon->discountAmount($subtotal);

        Session::put('coupon_code', $coupon->code);
        Session::put('discount_amount', $discount);

        $summary = $this->buildSummary($subtotal, $discount, $coupon->code);

        return $this->respond($request, [
            'success' => true,
            'coupon_code' => $coupon->code,
            'discount' => $discount,
            'summary' => $summary,
        ]);
    }

    public function remove(Request $request)
    {
        Session::forget('coupon_code');
        Session::forget('discount_amount');

        $cart = Session::get('cart', []);
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $subtotal += $product->final_price * (int) $qty;
            }
        }

        $summary = $this->buildSummary($subtotal, 0, null);

        return $this->respond($request, [
            'success' => true,
            'coupon_code' => null,
            'discount' => 0,
            'summary' => $summary,
        ]);
    }

    private function buildSummary(float $subtotal, float $discount, ?string $couponCode): array
    {
        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 150);
        $shippingCost = (float) Setting::get('shipping_cost', 12);
        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingCost;
        $total = max(0, $subtotal + $shipping - $discount);

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'shipping_label' => $shipping === 0 ? 'Free' : number_format($shipping, 2),
            'discount' => $discount,
            'total' => $total,
            'coupon_code' => $couponCode,
        ];
    }

    private function respond(Request $request, array $data)
    {
        if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json($data);
        }

        if (isset($data['errors'])) {
            return back()->withErrors($data['errors'])->withInput();
        }

        return back()->with('coupon_success', 'Coupon applied! You saved ' . number_format($data['discount'], 2) . '.');
    }
}
