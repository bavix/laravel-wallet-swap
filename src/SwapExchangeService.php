<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\Wallet\Internal\Service\MathServiceInterface;
use Bavix\Wallet\Services\ExchangeServiceInterface;
use Exchanger\CurrencyPair;
use Swap\Swap;

final class SwapExchangeService implements ExchangeServiceInterface
{
    private MathServiceInterface $mathService;
    private Swap $swapService;

    public function __construct(
        MathServiceInterface $mathService,
        Swap $swapService
    ) {
        $this->mathService = $mathService;
        $this->swapService = $swapService;
    }

    /** @param float|int|string $amount */
    public function convertTo(string $fromCurrency, string $toCurrency, $amount): string
    {
        return $this->mathService->mul(
            $amount,
            $this->rate($fromCurrency, $toCurrency)
        );
    }

    private function rate(string $fromCurrency, string $toCurrency): string
    {
        $pair = new CurrencyPair($fromCurrency, $toCurrency);
        if (!$pair->isIdentical()) {
            return (string) $this->swapService->latest((string) $pair)->getValue();
        }

        return '1';
    }
}
