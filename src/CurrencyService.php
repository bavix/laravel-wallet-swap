<?php

declare(strict_types=1);

namespace Bavix\WalletSwap;

use Bavix\WalletSwap\Exception\CacheException;
use Bavix\WalletSwap\Exception\NonBreakingInvalidArgumentException;
use Bavix\WalletSwap\Exception\SwapException;
use Bavix\WalletSwap\Exception\SwapRuntimeException;
use Bavix\WalletSwap\Exception\UnsupportedCurrencyPairException;
use Bavix\WalletSwap\Exception\UnsupportedDateException;
use Bavix\WalletSwap\Exception\UnsupportedExchangeQueryException;
use Exchanger\Exception\CacheException as ExchangerCacheException;
use Exchanger\Exception\Exception as ExchangerException;
use Exchanger\Exception\NonBreakingInvalidArgumentException as ExchangerNonBreakingInvalidArgumentException;
use Exchanger\Exception\UnsupportedCurrencyPairException as ExchangerUnsupportedCurrencyPairException;
use Exchanger\Exception\UnsupportedDateException as ExchangerUnsupportedDateException;
use Exchanger\Exception\UnsupportedExchangeQueryException as ExchangerUnsupportedExchangeQueryException;
use Swap\Swap;

final class CurrencyService implements CurrencyServiceInterface
{
    private Swap $swapService;

    public function __construct(Swap $swapService)
    {
        $this->swapService = $swapService;
    }

    /**
     * @throws CacheException
     * @throws NonBreakingInvalidArgumentException
     * @throws UnsupportedExchangeQueryException
     * @throws UnsupportedCurrencyPairException
     * @throws UnsupportedDateException
     * @throws SwapException
     * @throws SwapRuntimeException
     */
    public function rate(string $fromCurrency, string $toCurrency): string
    {
        if (strtolower($fromCurrency) === strtolower($toCurrency)) {
            return '1';
        }

        try {
            return (string) $this->swapService
                ->latest(strtoupper($fromCurrency.'/'.$toCurrency))
                ->getValue()
            ;
        } catch (ExchangerCacheException $exception) {
            throw new CacheException($exception->getMessage(), 0, $exception);
        } catch (ExchangerNonBreakingInvalidArgumentException $exception) {
            throw new NonBreakingInvalidArgumentException($exception->getMessage(), 0, $exception);
        } catch (ExchangerUnsupportedExchangeQueryException $exception) {
            throw new UnsupportedExchangeQueryException($exception->getMessage(), 0, $exception);
        } catch (ExchangerUnsupportedCurrencyPairException $exception) {
            throw new UnsupportedCurrencyPairException($exception->getMessage(), 0, $exception);
        } catch (ExchangerUnsupportedDateException $exception) {
            throw new UnsupportedDateException($exception->getMessage(), 0, $exception);
        } catch (ExchangerException $exception) {
            throw new SwapException($exception->getMessage(), 0, $exception);
        } catch (\Throwable $exception) {
            throw new SwapRuntimeException($exception->getMessage(), 0, $exception);
        }
    }
}
