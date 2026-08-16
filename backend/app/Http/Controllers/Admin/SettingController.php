<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            Setting::set($key, $value, $this->guessGroup($key));
        }

        return back()->with('success', 'Settings updated.');
    }

    private function guessGroup(string $key): string
    {
        $groups = [
            'store' => ['store_name', 'store_email', 'store_phone', 'store_address', 'store_currency'],
            'seo' => ['meta_title', 'meta_description'],
            'shipping' => ['free_shipping_threshold', 'shipping_cost'],
        ];

        foreach ($groups as $group => $keys) {
            if (in_array($key, $keys)) return $group;
        }
        return 'general';
    }
}
