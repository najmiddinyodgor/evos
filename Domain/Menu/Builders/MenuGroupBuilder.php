<?php
declare(strict_types=1);

namespace Domain\Menu\Builders;

use Domain\Menu\Entities\Meal;
use Domain\Menu\Entities\MenuGroup;
use InvalidArgumentException;

final class MenuGroupBuilder
{
  private int $id = 1;
  private string $name;
  /** @var Meal[] $items */
  private array $items;

  public function withName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function withItem(Meal $item): self
  {
    $this->items[] = $item;

    return $this;
  }

  public function reset(): self
  {
    $this->name = '';
    $this->items = [];

    return $this;
  }

  public function build(): MenuGroup
  {
    if (!$this->name) {
      throw new InvalidArgumentException('Name required');
    }

    if (empty($this->items)) {
      throw new InvalidArgumentException('Items empty');
    }

    return new MenuGroup(
      $this->id++,
      $this->name,
      $this->items
    );
  }
}