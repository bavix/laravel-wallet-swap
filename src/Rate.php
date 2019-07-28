<?php

namespace Bavix\WalletSwap;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Simple\Rate as Rateable;
use Exchanger\Contract\ExchangeRate as ExchangeRateContract;
use Exchanger\CurrencyPair;
use Illuminate\Support\Str;
use Swap\Laravel\Facades\Swap;

class Rate extends Rateable
{

    /**
     * @param Wallet $wallet
     * @return float
     */
    public function convertTo(Wallet $wallet): float
    {
        $from = Str::upper($this->withCurrency->slug);
        $to = Str::upper($wallet->slug);
        $pair = new CurrencyPair($from, $to);

        /**
         * @var $rate ExchangeRateContract
         */
        $rate = Swap::latest((string)$pair);

        return parent::convertTo($wallet) * $rate->getValue();
    }

}
