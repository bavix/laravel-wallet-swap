<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Test;

use Bavix\Wallet\WalletServiceProvider;
use Bavix\WalletSwap\WalletSwapServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Swap\Laravel\SwapServiceProvider;

/**
 * @internal
 */
class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate')->run();
    }

    /**
     * @param Application $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            WalletServiceProvider::class,
            WalletSwapServiceProvider::class,
            SwapServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        // swap
        $app['config']->set('swap.services', [
            'array' => [
                [
                    'EUR/USD' => round(114.19 / 100, 3),
                    'USD/EUR' => round(100 / 114.19, 3),
                    'BTC/USD' => round(42766 / 1., 3),
                    'USD/BTC' => round(1. / 42766, 3),
                ],
            ],
        ]);
    }
}
