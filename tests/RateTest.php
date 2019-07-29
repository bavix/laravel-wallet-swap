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
        $usd->holder_type = __CLASS__;
        $usd->holder_id = 1;
        $usd->name = 'Test';
        $usd->slug = 'usd';

        $eur = new Wallet();
        $eur->holder_type = __CLASS__;
        $eur->holder_id = 1;
        $eur->name = 'Test';
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
        $usd->name = 'Test';
        $usd->holder_type = __CLASS__;
        $usd->holder_id = 1;

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
        $usd->holder_type = __CLASS__;
        $usd->holder_id = 1;
        $usd->name = 'Test';

        $btc = new Wallet();
        $btc->slug = 'btc';
        $btc->holder_type = __CLASS__;
        $btc->holder_id = 1;
        $btc->name = 'Btcccc';

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
        $usd->holder_type = __CLASS__;
        $usd->holder_id = 1;
        $usd->name = 'Test';

        $btc = new Wallet();
        $btc->slug = 'btc';
        $btc->holder_type = __CLASS__;
        $btc->holder_id = 1;
        $btc->name = 'Test';

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
