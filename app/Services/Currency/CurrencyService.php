<?php

namespace App\Services\Currency;

class CurrencyService
{
    const RATES = [
        'usd' => [
            'eur' => 0.9075,
            'gbp' => 0.7951,
        ],
        'eur' => ['usd' => 1.1019],
    ];

    public function convert(float $amount, string $currencyFrom, string $currencyTo): float
    {
        $rate = self::RATES[$currencyFrom][$currencyTo] ?? 0;

        return round($amount * $rate, 2);
    }
}