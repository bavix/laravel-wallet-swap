<?php

namespace Bavix\WalletSwap;

use Bavix\Wallet\Interfaces\Mathable;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Services\WalletService;
use Bavix\Wallet\Simple\Rate as Rateable;
use Exchanger\Contract\ExchangeRate;
use Exchanger\CurrencyPair;
use Swap\Laravel\Facades\Swap;

class Rate extends Rateable
{
    /**
     * The method calculates the rate between currencies.
     * Makes a request for an API Swap and receives data.
     *
     * @param Wallet $wallet
     * @return int|float
     */
    public function rate(Wallet $wallet)
    {
        $from = app(WalletService::class)->getWallet($this->withCurrency);
        $to = app(WalletService::class)->getWallet($wallet);
        $pair = new CurrencyPair(
            $from->currency,
            $to->currency
        );

        if ($pair->isIdentical()) {
            /** is equal */
            return 1.;
        }

        /**
         * @var ExchangeRate $rate
         */
        $rate = Swap::latest($pair);

        return $rate->getValue();
    }

    /**
     * @param Wallet $wallet
     * @return float
     */
    public function convertTo(Wallet $wallet)
    {
        return app(Mathable::class)->mul(
            parent::convertTo($wallet),
            $this->rate($wallet)
        );
    }
}
