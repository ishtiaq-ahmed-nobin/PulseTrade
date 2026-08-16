<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function public(): JsonResponse
    {
        $keys = [
            'store_name',
            'store_email',
            'store_phone',
            'store_address',
            'store_currency',
            'meta_title',
            'meta_description',
            'free_shipping_threshold',
            'shipping_cost',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key);
        }

        return response()->json(['settings' => $settings]);
    }
}
