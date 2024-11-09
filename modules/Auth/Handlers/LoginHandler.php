<?php

namespace Auth\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Core\Libraries\SessionManager;
use Core\Libraries\ViewRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;

class LoginHandler
{
    public function __construct(
        private readonly ViewRenderer $viewRenderer,
        private readonly SessionManager $sessionManager
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        // if logged in, redirect to the dashboard
        if ($this->sessionManager->get('isLoggedIn')) {
            return new RedirectResponse('/');
        }

        return new HtmlResponse($this->viewRenderer->render('auth::login'));
    }
}
