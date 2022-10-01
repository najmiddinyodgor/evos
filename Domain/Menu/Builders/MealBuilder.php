<?php
declare(strict_types=1);

namespace Domain\Menu\Builders;

use Domain\Menu\Entities\Food;
use Domain\Menu\Entities\Meal;
use InvalidArgumentException;

final class MealBuilder
{
  private int $id = 1;
  private string $name;
  /** @var Food[] $items */
  private array $items;

  public function withName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function withItem(Food $item): self
  {
    $this->items[] = $item;

    return $this;
  }

  public function build(): Meal
  {
    if (!$this->name) {
      throw new InvalidArgumentException('Name required');
    }

    if (empty($this->items)) {
      throw new InvalidArgumentException('Items empty');
    }

    return new Meal(
      $this->id++,
      $this->name,
      $this->items,
    );
  }

  public function reset(): void
  {
    $this->name = '';
    $this->items = [];
  }
}