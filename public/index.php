<?php

use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require __DIR__.'/../vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface */
$app = require __DIR__.'/../bootstrap/app.php';

$request = ServerRequestFactory::fromGlobals();

$response = $app->get(\League\Route\Router::class)->dispatch($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
