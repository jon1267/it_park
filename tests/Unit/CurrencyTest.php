<?php

namespace Tests\Unit;

use App\Services\Currency\CurrencyService;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{

    public function test_convert_known_currencies_successful(): void
    {
        $usd_eur = (new CurrencyService())->convert(100, 'usd','eur');
        $usd_gbp = (new CurrencyService())->convert(100,'usd', 'gbp');

        // 90.75, 79.51, 110.19, we calculate on known rate from service
        $this->assertEquals(90.75, $usd_eur);
        $this->assertEquals(79.51, $usd_gbp);
        $this->assertEquals(110.19, (new CurrencyService())->convert(100, 'eur','usd'));
    }

    // this rate (usd to chf) unknown in service
    public function test_convert_usd_to_chf_return_zero()
    {
        $this->assertEquals(0, (new CurrencyService())->convert(100, 'eur','chf'));
    }
}
