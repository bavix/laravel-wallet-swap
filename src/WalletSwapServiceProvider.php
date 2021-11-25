<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\Wallet\Services\ExchangeServiceInterface;
use Illuminate\Support\ServiceProvider;

final class WalletSwapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @codeCoverageIgnore
     */
    public function register(): void
    {
        $this->app->singleton(ExchangeServiceInterface::class, SwapExchangeService::class);
    }
}
