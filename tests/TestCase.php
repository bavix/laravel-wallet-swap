<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Test;

use Bavix\Wallet\WalletServiceProvider;
use Bavix\WalletSwap\WalletSwapServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Swap\Laravel\SwapServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate')->run();
    }

    /**
     * @param Application $app
     * @return array
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
     * @return void
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
