<?php
namespace Core\View;

interface ViewInterface
{
    /**
     * Get the evaluated contents of the object
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function render($name, array $params = []);
}
