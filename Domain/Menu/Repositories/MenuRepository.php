<?php
declare(strict_types=1);

namespace Domain\Menu\Repositories;

use Domain\Menu\Builders\FoodBuilder;
use Domain\Menu\Builders\MealBuilder;
use Domain\Menu\Builders\MenuGroupBuilder;
use Domain\Menu\Entities\Meal;
use Domain\Menu\Entities\MenuGroup;
use InvalidArgumentException;

final class MenuRepository
{
  /**
   * @var MenuGroup[]
   */
  private array $groups;

  public function __construct()
  {
    $this->fillMenu();
  }

  /**
   * @return MenuGroup[]
   */
  public function getMenuGroups(): array
  {
    return $this->groups;
  }

  /**
   * @param int $group
   *
   * @return Meal[]
   */
  public function getGroupItems(int $group): array
  {
    $filtered = array_filter(
      $this->groups,
      fn(MenuGroup $menuGroup) => $menuGroup->id === $group
    );

    if (empty($filtered)) {
      throw new InvalidArgumentException('Group does not exist');
    } else {
      return $filtered[0]->items;
    }
  }

  private function fillMenu(): void
  {
    $groupBuilder = new MenuGroupBuilder();
    $this->createPitaGroup($groupBuilder);
    $groupBuilder->reset();
    $this->createBurgerGroup($groupBuilder);
    $groupBuilder->reset();
    $this->createComboGroup($groupBuilder);
  }

  private function createPitaGroup(MenuGroupBuilder $groupBuilder): void
  {
    $mealBuilder = new MealBuilder();
    $foodBuilder = new FoodBuilder();
    $this->groups[] = $groupBuilder
      ->withName('Лаваш')
      ->withItem(
        $mealBuilder
          ->withName('Лаваш с говядиной')
          ->withItem(
            $foodBuilder
              ->withPrice(25000)
              ->build()
          )
          ->build()
      )
      ->withItem(
        $mealBuilder
          ->withName('Лаваш с курицей')
          ->withItem(
            $foodBuilder
              ->withPrice(23000)
              ->build()
          )
          ->build()
      )
      ->build();
  }

  private function createBurgerGroup(MenuGroupBuilder $groupBuilder): void
  {
    $mealBuilder = new MealBuilder();
    $foodBuilder = new FoodBuilder();
    $this->groups[] = $groupBuilder
      ->withName('Бургеры')
      ->withItem(
        $mealBuilder
          ->withName('Гамбургер')
          ->withItem(
            $foodBuilder
              ->withPrice(20000)
              ->build()
          )
          ->build()
      )
      ->withItem(
        $mealBuilder
          ->withName('Чизбургер')
          ->withItem(
            $foodBuilder
              ->withPrice(29000)
              ->build()
          )
          ->build()
      )
      ->build();
  }

  private function createComboGroup(MenuGroupBuilder $groupBuilder): void
  {
    $mealBuilder = new MealBuilder();
    $foodBuilder = new FoodBuilder();
    $this->groups[] = $groupBuilder
      ->withName('COMBO')
      ->withItem(
        $mealBuilder
          ->withName('Комбо плюс')
          ->withItem(
            $foodBuilder
              ->withPrice(6000)
              ->build()
          )
          ->withItem(
            $foodBuilder
              ->withPrice(7000)
              ->build(),
          )
          ->build()
      )
      ->withItem(
        $mealBuilder
          ->withName('Детское комбо')
          ->withItem(
            $foodBuilder
              ->withPrice(5000)
              ->build()
          )
          ->withItem(
            $foodBuilder
              ->withPrice(6000)
              ->build()
          )
          ->withItem(
            $foodBuilder
              ->withPrice(14000)
              ->build(),
          )
          ->build()
      )
      ->build();
  }
}