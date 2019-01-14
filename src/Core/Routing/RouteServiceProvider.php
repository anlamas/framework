<?php
namespace Core\Routing;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface as Bootable;
use League\Route\Router;

class RouteServiceProvider extends AbstractServiceProvider implements Bootable
{
    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $this->map($this->getContainer()->get(Router::class));
    }

    public function map(Router $router)
    {
    }

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
