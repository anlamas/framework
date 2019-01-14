<?php
namespace Core\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;

class BasicAuthentication implements MiddlewareInterface
{
    /**
     * List of users
     *
     * @var array
     */
    protected $users = [];

    /**
     * Process an incoming server request.
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!is_null($username) && !is_null($username)) {
            foreach ($this->users as $name => $pass) {
                if ($username === $name && $pass === $password) {
                    return $handler->handle($request->withAttribute(
                        'auth_user',
                        $name
                    ));
                }
            }
        }

        return (new EmptyResponse(401))
            ->withHeader('WWW-Authenticate', 'Basic realm="Access denied"');
    }
}
