<?php

namespace Bavix\WalletSwap;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Simple\Rate as Rateable;
use Exchanger\Contract\ExchangeRate;
use Exchanger\CurrencyPair;
use Illuminate\Support\Str;
use Swap\Laravel\Facades\Swap;

class Rate extends Rateable
{

    /**
     * The method calculates the rate between currencies.
     * Makes a request for an API Swap and receives data.
     *
     * @param Wallet $wallet
     * @return float
     */
    public function rate(Wallet $wallet): float
    {
        $from = Str::upper($this->withCurrency->slug);
        $to = Str::upper($wallet->slug);
        $pair = new CurrencyPair($from, $to);

        if ($pair->isIdentical()) {
            /** is equal */
            return 1.;
        }

        /**
         * @var ExchangeRate $rate
         */
        $rate = Swap::latest((string)$pair);
        return $rate->getValue();
    }

    /**
     * @param Wallet $wallet
     * @return float
     */
    public function convertTo(Wallet $wallet): float
    {
        return parent::convertTo($wallet) * $this->rate($wallet);
    }

}
