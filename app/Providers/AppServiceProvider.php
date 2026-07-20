<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $symbols = [
            'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'JPY' => '¥', 'INR' => '₹',
            'CAD' => 'C$', 'AUD' => 'A$', 'CNY' => '¥', 'BRL' => 'R$', 'KRW' => '₩',
            'MXN' => 'Mex$', 'SEK' => 'kr', 'NOK' => 'kr', 'DKK' => 'kr', 'CHF' => 'CHF',
            'PLN' => 'zł', 'CZK' => 'Kč', 'ZAR' => 'R', 'SGD' => 'S$', 'HKD' => 'HK$',
        ];
        $code = Setting::get('store_currency', 'USD');
        $symbol = $symbols[strtoupper($code)] ?? strtoupper($code) . ' ';
        View::share('currency_symbol', $symbol);
    }
}
