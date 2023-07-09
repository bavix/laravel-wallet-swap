<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\Wallet\Services\ExchangeServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class WalletSwapServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(CurrencyServiceInterface::class, CurrencyService::class);
        $this->app->singleton(ExchangeServiceInterface::class, SwapExchangeService::class);
    }

    /**
     * @return class-string[]
     */
    public function provides(): array
    {
        return [CurrencyServiceInterface::class];
    }
}
