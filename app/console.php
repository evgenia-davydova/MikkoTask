<?php

require_once __DIR__ . '/../vendor/autoload_runtime.php';

use Symfony\Component\Console\Application;
use Commands\MoneydayCommand;

$app = new Application();
$app->add(new MoneydayCommand());
$app->run();
