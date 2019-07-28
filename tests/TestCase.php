<?php

namespace Bavix\WalletSwap\Test;

use Bavix\WalletSwap\RateServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Foundation\Application;
use Swap\Laravel\SwapServiceProvider;

class TestCase extends OrchestraTestCase
{

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            SwapServiceProvider::class,
            RateServiceProvider::class,
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
        $app['config']->set('swap.services', [
            'national_bank_of_romania' => true,
            'central_bank_of_republic_turkey' => true,
            'central_bank_of_czech_republic' => true,
            'russian_central_bank' => true,
            'webservicex' => true,
            'cryptonator' => true,
        ]);
    }

}
