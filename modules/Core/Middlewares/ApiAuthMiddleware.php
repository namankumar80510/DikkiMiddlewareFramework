<?php

declare(strict_types=1);

namespace Core\Middlewares;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiAuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        
        // Check if request is from same application
        $referer = $request->getHeaderLine('referer');
        if (!empty($referer)) {
            try {
                $refererHost = parse_url($referer, PHP_URL_HOST);
                if ($refererHost === $request->getUri()->getHost()) {
                    return $handler->handle($request);
                }
            } catch (\Exception $e) {
                // Invalid referer URL, continue with API key validation
            }
        }
        
        // Check if path is whitelisted
        foreach (config('auth.api_auth_login_middleware_whitelist') as $whitelistedPath) {
            if (str_ends_with($whitelistedPath, '*')) {
                $prefix = rtrim($whitelistedPath, '*');
                if (str_starts_with($path, $prefix)) {
                    return $handler->handle($request);
                }
            } elseif ($path === $whitelistedPath) {
                return $handler->handle($request);
            }
        }

        $apiKey = $request->getHeaderLine('x-api-key');

        if (empty($apiKey) || !in_array($apiKey, config('api_keys.api_keys'))) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Invalid or missing API key'
            ], 401);
        }

        return $handler->handle($request);
    }
}
