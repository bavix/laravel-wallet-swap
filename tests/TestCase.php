<?php

namespace Bavix\WalletSwap\Test;

use Bavix\Wallet\WalletServiceProvider;
use Bavix\WalletSwap\RateServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Foundation\Application;
use Swap\Laravel\SwapServiceProvider;

class TestCase extends OrchestraTestCase
{

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            WalletServiceProvider::class,
            RateServiceProvider::class,
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

        // database
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

}
