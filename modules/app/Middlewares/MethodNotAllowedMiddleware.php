<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Libraries\ApiResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MethodNotAllowedMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        
        // Check if this is an API request
        if (str_contains($path, '/api/')) {
            return ApiResponse::error('Method not allowed', 405);
        }

        return new HtmlResponse(file_get_contents(__DIR__ . '/../Views/5xx.html'), 405);
    }
}
