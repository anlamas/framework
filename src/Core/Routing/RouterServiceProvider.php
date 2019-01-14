<?php
namespace Core\Routing;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;

class RouterServiceProvider extends AbstractServiceProvider
{
    protected $provides
        = [
            Router::class,
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
        $this->getContainer()->share(Router::class, function () {
            $strategy
                = (new \League\Route\Strategy\ApplicationStrategy)->setContainer($this->getContainer());

            $router = new Router();
            $router->setStrategy($strategy);

            return $router;
        });
    }
}
