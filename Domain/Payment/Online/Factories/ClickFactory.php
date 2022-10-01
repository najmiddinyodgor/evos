<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Factories;

use Domain\Payment\Online\Contracts\PaymentIntegration;
use Domain\Payment\Online\Contracts\PaymentIntegrationFactory;
use Domain\Payment\Online\Entities\Click;

final class ClickFactory extends PaymentIntegrationFactory
{
  public function factory(): PaymentIntegration
  {
    return new Click(getenv('CLICK_TOKEN'));
  }
}