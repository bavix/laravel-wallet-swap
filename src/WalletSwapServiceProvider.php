<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\Wallet\Services\ExchangeServiceInterface;
use Illuminate\Support\ServiceProvider;

class WalletSwapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->app->singleton(ExchangeServiceInterface::class, SwapExchangeService::class);
    }
}
