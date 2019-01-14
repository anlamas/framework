<?php
namespace App\Providers;

use Core\Routing\RouteServiceProvider as ServiceProvider;
use League\Route\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @param Router $router
     * @return  void
     */
    public function map(Router $router)
    {
        $this->mapApiRoutes($router);
        $this->mapWebRoutes($router);
    }

    /**
     * Feel free to configure or organize your api routes
     *
     * @param Router $router
     * @return  void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group('api', function () use ($router) {
            require __DIR__.'/../../../routes/api.php';
        });
    }

    /**
     * Feel free to configure or organize your api routes
     *
     * @param Router $router
     * @return  void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group('web', function () use ($router) {
            require __DIR__.'/../../../routes/web.php';
        });
    }
}
