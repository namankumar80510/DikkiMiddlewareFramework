<?php

declare(strict_types=1);

namespace Auth\Handlers;

use Core\Libraries\SessionManager;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutHandler
{
    public function __construct(private SessionManager $sessionManager) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $this->sessionManager->destroy();
        return new RedirectResponse('/auth/login');
    }
}
