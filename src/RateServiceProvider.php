<?php

namespace Bavix\WalletSwap;

use Illuminate\Support\ServiceProvider;
use Bavix\Wallet\Interfaces\Rateable;

class RateServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->app->singleton(Rateable::class, Rate::class);
    }

}
