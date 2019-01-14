<?php

use League\Container\Container;
use League\Container\ReflectionContainer;

$container = new Container();
$container->delegate(new ReflectionContainer());

$container->addServiceProvider(\Core\Config\ConfigServiceProvider::class);
$container->addServiceProvider(\Core\Database\DatabaseServiceProvider::class);
$container->addServiceProvider(\Core\Routing\RouterServiceProvider::class);
$container->addServiceProvider(\App\Providers\RouteServiceProvider::class);
$container->addServiceProvider(\Core\View\ViewServiceProvider::class);

return $container;
