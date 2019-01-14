<?php

use Symfony\Component\Console\Helper\HelperSet;

require __DIR__.'/vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface */
$app = require __DIR__.'/bootstrap/app.php';

return new HelperSet([
    new \Symfony\Component\Console\Helper\FormatterHelper(),
    new \Symfony\Component\Console\Helper\DebugFormatterHelper(),
    new \Symfony\Component\Console\Helper\ProcessHelper(),
    new \Symfony\Component\Console\Helper\QuestionHelper(),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($app->get(\Doctrine\ORM\EntityManagerInterface::class))
]);
