<?php
declare(strict_types=1);

namespace Domain\Checkout\UseCases\Online;

use Domain\Cart\Entities\Cart;
use Domain\Payment\Online\Contracts\PaymentIntegrationFactory;
use Domain\Payment\Online\Enums\PaymentIntegrationEnum;
use Domain\Payment\Online\Exceptions\UnsupportedPaymentMethod;

final class CreateInvoice
{
  /**
   * @throws UnsupportedPaymentMethod
   */
  public function handle(PaymentIntegrationEnum $paymentType, Cart $cart): string
  {
    $payment = PaymentIntegrationFactory::make($paymentType);
    return $payment->createInvoice(
      $cart->calculateTotal()
    );
  }
}