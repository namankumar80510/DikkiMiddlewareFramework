<?php

declare(strict_types=1);

namespace Auth\Middlewares;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $continue = $handler->handle($request);

        $path = $request->getUri()->getPath();
        $isWhitelisted = false;

        foreach (config('auth.auth_middleware_whitelist') as $whitelistedPath) {
            if (str_ends_with($whitelistedPath, '*')) {
                $prefix = rtrim($whitelistedPath, '*');
                if (str_starts_with($path, $prefix)) {
                    $isWhitelisted = true;
                    break;
                }
            } elseif ($path === $whitelistedPath) {
                $isWhitelisted = true;
                break;
            }
        }

        if (!$isWhitelisted && !isLoggedIn()) {
            return new RedirectResponse('/auth/login');
        }

        return $continue;
    }
}
