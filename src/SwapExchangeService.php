<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\Wallet\Internal\Service\MathServiceInterface;
use Bavix\Wallet\Services\ExchangeServiceInterface;
use Bavix\WalletSwap\Exception\CacheException;
use Bavix\WalletSwap\Exception\NonBreakingInvalidArgumentException;
use Bavix\WalletSwap\Exception\SwapException;
use Bavix\WalletSwap\Exception\SwapRuntimeException;
use Bavix\WalletSwap\Exception\UnsupportedCurrencyPairException;
use Bavix\WalletSwap\Exception\UnsupportedDateException;
use Bavix\WalletSwap\Exception\UnsupportedExchangeQueryException;

final class SwapExchangeService implements ExchangeServiceInterface
{
    public function __construct(private CurrencyServiceInterface $currencyService, private MathServiceInterface $mathService)
    {
    }

    /**
     * @throws CacheException
     * @throws NonBreakingInvalidArgumentException
     * @throws UnsupportedExchangeQueryException
     * @throws UnsupportedCurrencyPairException
     * @throws UnsupportedDateException
     * @throws SwapException
     * @throws SwapRuntimeException
     */
    public function convertTo(string $fromCurrency, string $toCurrency, float|int|string $amount): string
    {
        return $this->mathService->mul($this->currencyService->rate($fromCurrency, $toCurrency), $amount);
    }
}
