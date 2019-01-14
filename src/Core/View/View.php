<?php
namespace Core\View;

use Twig\Environment;

class View implements ViewInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var null
     */
    private $extension;

    /**
     * View constructor.
     *
     * @param Environment $twig
     * @param null        $extension
     */
    public function __construct(Environment $twig, $extension = null)
    {
        $this->twig = $twig;
        $this->extension = $extension;
    }

    /**
     * Get the evaluated contents of the object
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($name, array $params = [])
    {
        return $this->twig->render($name.$this->extension, $params);
    }
}
