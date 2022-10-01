<?php
declare(strict_types=1);

namespace Domain\Cart\Entities;

use Domain\Menu\Entities\Meal;

final class Cart
{
  private array $orders;

  public function addOrder(Meal $order): void
  {
    $this->orders[] = $order;
  }

  public function calculateTotal(): int
  {
    return array_sum(
      array_map(
        fn(Meal $meal) => $meal->getPrice(),
        $this->orders
      )
    );
  }
}