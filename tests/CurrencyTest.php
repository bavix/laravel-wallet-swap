<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Test;

use Bavix\WalletSwap\CurrencyService;
use Bavix\WalletSwap\Exception\CacheException;
use Bavix\WalletSwap\Exception\NonBreakingInvalidArgumentException;
use Bavix\WalletSwap\Exception\SwapException;
use Bavix\WalletSwap\Exception\SwapRuntimeException;
use Bavix\WalletSwap\Exception\UnsupportedCurrencyPairException;
use Bavix\WalletSwap\Exception\UnsupportedDateException;
use Bavix\WalletSwap\Exception\UnsupportedExchangeQueryException;
use DateTimeImmutable;
use Exchanger\CurrencyPair;
use Exchanger\Exception\CacheException as ExchangerCacheException;
use Exchanger\Exception\ChainException;
use Exchanger\Exception\Exception as ExchangerException;
use Exchanger\Exception\NonBreakingInvalidArgumentException as ExchangerNonBreakingInvalidArgumentException;
use Exchanger\Exception\UnsupportedCurrencyPairException as ExchangerUnsupportedCurrencyPairException;
use Exchanger\Exception\UnsupportedDateException as ExchangerUnsupportedDateException;
use Exchanger\Exception\UnsupportedExchangeQueryException as ExchangerUnsupportedExchangeQueryException;
use Exchanger\ExchangeRateQuery;
use Exchanger\Service\PhpArray;
use RuntimeException;
use Swap\Swap;
use Throwable;

/**
 * @internal
 */
final class CurrencyTest extends TestCase
{
    /**
     * @dataProvider exceptionDataProvider
     */
    public function testExceptions(string $expect, Throwable $throwable): void
    {
        $this->expectException($expect);

        $mockSwapService = $this->createMock(Swap::class);
        $mockSwapService->method('latest')->willThrowException($throwable);

        $currencyService = new CurrencyService($mockSwapService);
        $currencyService->rate('USD', 'RUB');
    }

    public function exceptionDataProvider(): iterable
    {
        $currencyPair = new CurrencyPair('USD', 'EUR');
        $service = new PhpArray([]);

        yield [CacheException::class, new ExchangerCacheException()];
        yield [NonBreakingInvalidArgumentException::class, new ExchangerNonBreakingInvalidArgumentException()];

        yield [
            UnsupportedExchangeQueryException::class,
            new ExchangerUnsupportedExchangeQueryException(new ExchangeRateQuery($currencyPair), $service),
        ];

        yield [
            UnsupportedCurrencyPairException::class,
            new ExchangerUnsupportedCurrencyPairException($currencyPair, $service),
        ];

        yield [
            UnsupportedDateException::class,
            new ExchangerUnsupportedDateException(new DateTimeImmutable(), $service),
        ];

        yield [
            SwapException::class,
            new ExchangerException(),
        ];

        yield [
            SwapException::class,
            new ChainException([]),
        ];

        yield [
            SwapRuntimeException::class,
            new RuntimeException(),
        ];
    }
}
