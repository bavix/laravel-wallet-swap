<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Exception;

use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
use Exception;

final class UnsupportedExchangeQueryException extends Exception implements ExceptionInterface
{
}
