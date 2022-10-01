<?php
declare(strict_types=1);

namespace Domain\Menu\Builders;

use Domain\Menu\Entities\Food;
use InvalidArgumentException;

final class FoodBuilder
{
  private int $id = 1;
  private int $price;

  public function withPrice(int $price): self
  {
    $this->price = $price;

    return $this;
  }

  public function build(): Food
  {
    if (!$this->price) {
      throw new InvalidArgumentException('Price required');
    }

    return new Food(
      $this->id,
      $this->price,
    );
  }
}