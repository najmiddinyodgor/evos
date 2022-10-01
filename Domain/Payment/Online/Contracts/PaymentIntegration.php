<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Contracts;

interface PaymentIntegration
{
  function createInvoice(int $total): string;
}