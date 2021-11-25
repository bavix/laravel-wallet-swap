<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Test;

use Bavix\Wallet\Internal\Service\MathServiceInterface;
use Bavix\Wallet\Services\ExchangeServiceInterface;
use Exchanger\ExchangeRate;
use Swap\Laravel\Facades\Swap;

/**
 * @internal
 */
class SwapTest extends TestCase
{
    public function testSimple(): void
    {
        $mathService = app(MathServiceInterface::class);
        $value = app(ExchangeServiceInterface::class)
            ->convertTo('USD', 'EUR', 99)
        ;

        /** @var ExchangeRate $expected */
        $expected = Swap::latest('USD/EUR');

        self::assertSame(0, $mathService->compare($expected->getValue() * 99, $value));
    }

    public function testIdentical(): void
    {
        $mathService = app(MathServiceInterface::class);
        $value = app(ExchangeServiceInterface::class)
            ->convertTo('USD', 'USD', 128)
        ;

        self::assertSame(0, $mathService->compare(128, $value));
    }

    public function testCryptoBtcUsd(): void
    {
        $mathService = app(MathServiceInterface::class);
        $value = app(ExchangeServiceInterface::class)
            ->convertTo('BTC', 'USD', 20)
        ;

        /** @var ExchangeRate $expected */
        $expected = Swap::latest('BTC/USD');

        self::assertSame(0, $mathService->compare($expected->getValue() * 20, $value));
    }

    public function testCryptoUsdBtc(): void
    {
        $mathService = app(MathServiceInterface::class);
        $value = app(ExchangeServiceInterface::class)
            ->convertTo('USD', 'BTC', 100)
        ;

        /** @var ExchangeRate $expected */
        $expected = Swap::latest('USD/BTC');
        self::assertSame(0, $mathService->compare($expected->getValue() * 100, $value));
    }
}
