<?php
declare(strict_types=1);

namespace Console\Commands;

use Domain\Cart\Entities\Cart;
use Domain\Checkout\UseCases\Online\CreateInvoice;
use Domain\Menu\Entities\Meal;
use Domain\Menu\Entities\MenuGroup;
use Domain\Menu\Repositories\MenuRepository;
use Domain\Payment\Online\Enums\PaymentIntegrationEnum;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

#[AsCommand(
  name: 'app:make-order',
  hidden: false
)]
final class MakeOrderCommand extends Command
{
  protected static $defaultDescription = 'Order food';
  private QuestionHelper $questionHelper;
  private InputInterface $input;
  private OutputInterface $output;

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $this->questionHelper = $this->getHelper('question');
    $this->input = $input;
    $this->output = $output;

    $cart = $this->makeOrder();
    $paymentType = $this->askPaymentType();

    $handler = new CreateInvoice();
    $invoice = $handler->handle($paymentType, $cart);

    $output->writeln("Checkout: $invoice");

    return Command::SUCCESS;
  }

  private function makeOrder(): Cart
  {
    $cart = new Cart();
    $takingOrder = true;
    $repository = new MenuRepository();

    while ($takingOrder) {
      foreach ($this->takeOrder($repository) as $order) {
        $cart->addOrder($order);
      }
      $question = new ConfirmationQuestion('Would you order something else?', false);
      $takingOrder = $this->questionHelper->ask($this->input, $this->output, $question);
    }

    return $cart;
  }

  /**
   * @return Meal[]
   */
  private function takeOrder(MenuRepository $repository): array
  {
    $group = $this->askGroup($repository->getMenuGroups());
    return $this->askMeals($group->items);
  }

  /**
   * @param MenuGroup[] $groups
   *
   * @return MenuGroup
   */
  private function askGroup(array $groups): MenuGroup
  {
    $namedGroups = [];
    foreach ($groups as $group) {
      $namedGroups[$group->name] = $group;
    }

    $question = new ChoiceQuestion(
      'What do you want to order?',
      array_keys($namedGroups),
      0
    );
    $chosenGroup = $this->questionHelper->ask($this->input, $this->output, $question);

    return $namedGroups[$chosenGroup];
  }

  /**
   * @param Meal[] $meals
   *
   * @return Meal[]
   */
  private function askMeals(array $meals): array
  {
    $namedMeals = [];
    foreach ($meals as $meal) {
      $namedMeals[$meal->name] = $meal;
    }

    $question = new ChoiceQuestion(
      'What do you want to order?',
      array_keys($namedMeals),
      0
    );
    $question->setMultiselect(true);
    $chosenMeals = $this->questionHelper->ask($this->input, $this->output, $question);

    return array_map(
      fn(string $meal) => $namedMeals[$meal],
      $chosenMeals
    );
  }

  private function askPaymentType(): PaymentIntegrationEnum
  {
    $paymentTypes = array_flip(PaymentIntegrationEnum::options());

    $question = new ChoiceQuestion(
      'Select payment type',
      array_keys($paymentTypes)
    );

    $chosenType = $this->questionHelper->ask($this->input, $this->output, $question);

    return PaymentIntegrationEnum::from(
      $paymentTypes[$chosenType]
    );
  }
}