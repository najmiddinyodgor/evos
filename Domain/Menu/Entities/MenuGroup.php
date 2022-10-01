<?php
declare(strict_types=1);

namespace Domain\Menu\Entities;

final class MenuGroup
{
  /**
   * @param int $id
   * @param string $name
   * @param Meal[] $items
   */
  public function __construct(
    public readonly int    $id,
    public readonly string $name,
    public readonly array  $items
  )
  {
  }
}