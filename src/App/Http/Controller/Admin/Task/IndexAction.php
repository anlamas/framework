<?php
namespace App\Http\Controller\Admin\Task;

use Core\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction
{
    /**
     * @var ViewInterface
     */
    protected $engine;


    /**
     * IndexAction constructor.
     *
     * @param ViewInterface $engine
     */
    public function __construct(ViewInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse($this->engine->render('admin'));
    }
}
