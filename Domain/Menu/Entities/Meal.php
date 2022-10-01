<?php
declare(strict_types=1);

namespace Domain\Menu\Entities;

final class Meal
{
  /**
   * @param int $id
   * @param string $name
   * @param Food[] $items
   */
  public function __construct(
    public readonly int    $id,
    public readonly string $name,
    public readonly array  $items
  )
  {
  }

  public function getPrice(): int
  {
    return array_sum(
      array_map(
        fn(Food $item) => $item->price,
        $this->items
      )
    );
  }
}