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

    /**
     * @return void
     */
    public function testCryptoBTCUSD(): void
    {
        $usd = new Wallet();
        $usd->slug = 'usd';

        $btc = new Wallet();
        $btc->slug = 'btc';

        $rate = (new Rate())
            ->withCurrency($btc)
            ->withAmount(20);

        /**
         * @var ExchangeRate $expected
         */
        $expected = Swap::latest('BTC/USD');

        $this->assertEquals($expected->getValue() * 20, $rate->convertTo($usd));
    }

    /**
     * @return void
     */
    public function testCryptoUSDBTC(): void
    {
        $usd = new Wallet();
        $usd->slug = 'usd';

        $btc = new Wallet();
        $btc->slug = 'btc';

        $rate = (new Rate())
            ->withCurrency($usd)
            ->withAmount(100);

        /**
         * @var ExchangeRate $expected
         */
        $expected = Swap::latest('USD/BTC');

        $this->assertEquals($expected->getValue() * 100, $rate->convertTo($btc));
    }

}
