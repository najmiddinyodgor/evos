<?php
declare(strict_types=1);

namespace Domain\Menu\Entities;

final class Food
{
  /**
   * @param int $id
   * @param int $price
   */
  public function __construct(
    public readonly int $id,
    public readonly int $price
  )
  {
  }
}