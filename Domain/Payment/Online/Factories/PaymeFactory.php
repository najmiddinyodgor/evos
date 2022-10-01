<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Factories;

use Domain\Payment\Online\Contracts\PaymentIntegration;
use Domain\Payment\Online\Contracts\PaymentIntegrationFactory;
use Domain\Payment\Online\Entities\Payme;

final class PaymeFactory extends PaymentIntegrationFactory
{
  public function factory(): PaymentIntegration
  {
    return new Payme(getenv('PAYME_TOKEN'));
  }
}