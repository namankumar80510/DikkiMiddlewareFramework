<?php

declare(strict_types=1);

namespace {module}\Handlers;

use App\Libraries\ViewRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class {name}Handler
{

    public function __construct(
        private readonly ViewRenderer $view
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        // Handle the request and return response
        return new HtmlResponse($this->view->render('{name}'));
    }
}
