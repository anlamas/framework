<?php
/**
 * @var \League\Route\Router $router
 */

$router->get('/', \App\Http\Controller\Task\IndexAction::class)
    ->setName('task.index');

$router->get('/tasks', \App\Http\Controller\Task\ListAction::class)
    ->setName('task.list');

$router->post('/tasks', \App\Http\Controller\Task\StoreAction::class)
    ->setName('task.store');

$router->post('/tasks/{id}', \App\Http\Controller\Task\UpdateAction::class)
    ->setName('task.update');

$router->get('/admin', \App\Http\Controller\Admin\Task\IndexAction::class)
    ->setName('admin.task.index')
    ->middleware(new \App\Http\Middleware\BasicAuthentication());
