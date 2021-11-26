<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Exception;

use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
use RuntimeException;

final class SwapRuntimeException extends RuntimeException implements ExceptionInterface
{
}
