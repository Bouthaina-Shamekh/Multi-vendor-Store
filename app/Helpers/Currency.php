<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency
{
    // عشان استدعي هاد الكلاس ك فانشكن بعمل انفوك 
    // والبارميتر الي جواها عبارة عن مصفوفة كل الباراميتر الي جوا فانكشن الفورمات
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }

    public static function format($amount, $currency = null)
    {
        // $baseCurrency = config('app.currency', 'USD');

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        
        if ($currency === null) {
            // $currency = Session::get('currency_code', $baseCurrency);
            $currency = config('app.currency' , 'USD');
        }

        return $formatter->formatCurrency($amount, $currency);

        // if ($currency != $baseCurrency) {
        //     $rate = Cache::get('currency_rate_' . $currency, 1);
        //     $amount = $amount * $rate;
        // }

        // return $formatter->formatCurrency($amount, $currency);
    }
}