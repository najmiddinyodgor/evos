<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Enums;

enum PaymentIntegrationEnum: int
{
  case PAYME = 1;
  case CLICK = 2;


  public static function options(): array
  {
    return [
      self::PAYME->value => 'PayMe',
      self::CLICK->value => 'Click'
    ];
  }
}