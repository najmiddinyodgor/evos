<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Contracts;

use Domain\Payment\Online\Entities\Payme;
use Domain\Payment\Online\Enums\PaymentIntegrationEnum;
use Domain\Payment\Online\Exceptions\UnsupportedPaymentMethod;
use Domain\Payment\Online\Factories\ClickFactory;
use Domain\Payment\Online\Factories\PaymeFactory;

abstract class PaymentIntegrationFactory
{
  /**
   * @throws UnsupportedPaymentMethod
   */
  public static function make(PaymentIntegrationEnum $type): PaymentIntegration
  {
    return match ($type) {
      PaymentIntegrationEnum::PAYME => (new PaymeFactory())->factory(),
      PaymentIntegrationEnum::CLICK => (new ClickFactory())->factory(),
      default => throw new UnsupportedPaymentMethod()
    };
  }

  public abstract function factory(): PaymentIntegration;
}