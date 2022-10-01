<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/config/bootstrap.php';

use Console\Commands\MakeOrderCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new MakeOrderCommand());

$application->run();