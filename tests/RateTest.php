<?php

namespace Bavix\WalletSwap\Test;

use Bavix\Wallet\Models\Wallet;
use Bavix\WalletSwap\Rate;
use Exchanger\ExchangeRate;
use Swap\Laravel\Facades\Swap;

class RateTest extends TestCase
{

    /**
     * @return void
     */
    public function testSimple(): void
    {
        $usd = new Wallet();
        $usd->slug = 'usd';

        $eur = new Wallet();
        $eur->slug = 'eur';

        $rate = (new Rate())
            ->withCurrency($usd)
            ->withAmount(99);

        /**
         * @var ExchangeRate $expected
         */
        $expected = Swap::latest('USD/EUR');

        $this->assertEquals($expected->getValue() * 99, $rate->convertTo($eur));
    }

    /**
     * @return void
     */
    public function testIdentical(): void
    {
        $usd = new Wallet();
        $usd->slug = 'usd';

        $rate = (new Rate())
            ->withCurrency($usd)
            ->withAmount(128);

        $this->assertEquals(128, $rate->convertTo($usd));
    }

}
