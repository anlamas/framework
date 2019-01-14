<?php
namespace App\Http\Controller\Task;

use App\Services\TaskService;
use Core\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class ListAction
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var TaskService
     */
    private $service;

    /**
     * ListAction constructor.
     *
     * @param ViewInterface $view
     * @param TaskService   $service
     */
    public function __construct(ViewInterface $view, TaskService $service)
    {
        $this->view = $view;
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $data = $this->service->paginate($request->getQueryParams());

        return new JsonResponse($data->toArray());
    }
}
