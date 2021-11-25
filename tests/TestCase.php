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
            'national_bank_of_romania' => true,
            'central_bank_of_republic_turkey' => true,
            'central_bank_of_czech_republic' => true,
            'russian_central_bank' => true,
            'cryptonator' => true,
        ]);
    }
}
