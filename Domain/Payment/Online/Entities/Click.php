<?php
declare(strict_types=1);

namespace Domain\Payment\Online\Entities;

use Domain\Payment\Online\Contracts\PaymentIntegration;
use GuzzleHttp\Client;

final class Click implements PaymentIntegration
{
  private Client $client;

  public function __construct(
    private string $authKey
  )
  {
    $this->client = new Client([
      'headers' => [
        'Authorization' => $this->authKey
      ]
    ]);
  }

  function createInvoice(int $total): string
  {
    return 'https://click.uz/checkout/fake';
  }
}