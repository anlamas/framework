<?php

namespace Core\Database;

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        \PDO::class,
        EntityManagerInterface::class
    ];
    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()->add(\PDO::class, function () {
            $config = $this->getContainer()->get(\Core\Config\ConfigInterface::class);

            $connection = $config->get('db.default');

            $db = $config->get('db.connections.'.$connection);

            $dsn = $db['driver'] .
                ':host=' . $db['host'] .
                ';port=' . $db['port'] .
                ';dbname=' . $db['database'];
            return new \PDO($dsn, $db['username'], $db['password']);
        }, true);


        $this->getContainer()->add(EntityManagerInterface::class, function () {
            return (new EntityManagerFactory())->__invoke($this->getContainer());
        });
    }
}
