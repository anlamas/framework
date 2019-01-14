<?php
namespace App\Http\Controller\Task;

use App\Services\TaskService;
use Core\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UpdateAction
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
     * UpdateAction constructor.
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
     * @param                        $params
     *
     * @return JsonResponse
     */
    public function __invoke(ServerRequestInterface $request, $params)
    {
        $attributes = count($request->getParsedBody()) > 0
            ? $request->getParsedBody()
            : json_decode($request->getBody()->getContents(), true);

        $data = $this->service->update($params['id'], $attributes);

        return new JsonResponse($data);
    }
}
