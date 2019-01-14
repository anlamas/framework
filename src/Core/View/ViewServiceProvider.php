<?php
namespace Core\View;

use Core\Config\ConfigInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ViewInterface::class,
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
        $this->getContainer()->share(ViewInterface::class, function () {
            $config = $this->getContainer()->get(ConfigInterface::class);

            $loader = new FilesystemLoader($config->get('view.paths'));

            $twig = new Environment($loader, [
                'cache'       => $config->get('app.debug') ? false
                    : $config->get('view.cache'),
                'auto_reload' => $config->get('app.debug'),
            ]);

            return new View($twig, $config->get('view.extension'));
        }, true);
    }
}
