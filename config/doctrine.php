<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver_class' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'pdo' => PDO::class,
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entities' => 'entities',
                ],
            ],
            'entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'filesystem',
                'paths' => ['src/App/Entities'],
            ],
        ],
        'cache' => [
            'filesystem' => [
                'class' => \Doctrine\Common\Cache\FilesystemCache::class,
                'directory' => __DIR__. '/../storage/cache/DoctrineCache',
                'namespace' => 'container-interop-doctrine',
            ],
        ]
    ],
];
