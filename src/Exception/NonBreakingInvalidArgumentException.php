<?php

declare(strict_types=1);

namespace Bavix\WalletSwap\Exception;

use Bavix\Wallet\Internal\Exceptions\ExceptionInterface;
use InvalidArgumentException;

final class NonBreakingInvalidArgumentException extends InvalidArgumentException implements ExceptionInterface
{
}
