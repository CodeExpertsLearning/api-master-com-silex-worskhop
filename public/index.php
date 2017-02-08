<?php
chdir(dirname(__DIR__));

require 'vendor/autoload.php';

use ApiMaster\Service\ControllerServiceProvider;
use ApiMaster\Service\RouterServiceProvider;
use Silex\Application;

$app = new Application();

$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new RouterServiceProvider());
$app->register(new ControllerServiceProvider());

$app->run();