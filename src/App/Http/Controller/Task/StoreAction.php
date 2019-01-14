<?php
namespace App\Http\Controller\Task;

use App\Services\TaskService;
use Core\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class StoreAction
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
     * StoreAction constructor.
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
        $attributes = count($request->getParsedBody()) > 0
            ? $request->getParsedBody()
            : json_decode($request->getBody()->getContents(), true);

        $data = $this->service->store($attributes);

        return new JsonResponse($data);
    }
}
