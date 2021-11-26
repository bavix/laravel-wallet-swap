<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\WalletSwap\Exception\CacheException;
use Bavix\WalletSwap\Exception\NonBreakingInvalidArgumentException;
use Bavix\WalletSwap\Exception\SwapException;
use Bavix\WalletSwap\Exception\SwapRuntimeException;
use Bavix\WalletSwap\Exception\UnsupportedCurrencyPairException;
use Bavix\WalletSwap\Exception\UnsupportedDateException;
use Bavix\WalletSwap\Exception\UnsupportedExchangeQueryException;

interface CurrencyServiceInterface
{
    /**
     * @throws CacheException
     * @throws NonBreakingInvalidArgumentException
     * @throws UnsupportedExchangeQueryException
     * @throws UnsupportedCurrencyPairException
     * @throws UnsupportedDateException
     * @throws SwapException
     * @throws SwapRuntimeException
     */
    public function rate(string $fromCurrency, string $toCurrency): string;
}
