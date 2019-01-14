<?php
namespace Core\Config;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ConfigServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected $provides = [
        ConfigInterface::class,
        'config'
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
        $this->getContainer()->add(ConfigInterface::class, function () {
            $loader = new \Gestalt\Loaders\PhpDirectoryLoader(__DIR__
                .'/../../../config');
            $config = \Gestalt\Configuration::load($loader);

            return new Config($config);
        }, true);

        $this->getContainer()->add('config', function () {
            return require __DIR__ .'/../../../config/doctrine.php';
        });
    }

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $env = \Dotenv\Dotenv::create(__DIR__.'/../../../');
        $env->load();
    }
}
