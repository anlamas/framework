<?php
namespace App\Http\Controller\Task;

use Core\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * IndexAction constructor.
     *
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse(
            $this->view->render('index')
        );
    }
}
