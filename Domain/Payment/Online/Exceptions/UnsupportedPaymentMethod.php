<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Exceptions;

use Exception;
use Throwable;

final class UnsupportedPaymentMethod extends Exception
{
  public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
  {
    parent::__construct("Unsupported payment method", $code, $previous);
  }
}