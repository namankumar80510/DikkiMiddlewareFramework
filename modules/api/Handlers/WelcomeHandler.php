<?php

declare(strict_types=1);

namespace Api\Handlers;

use App\Libraries\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WelcomeHandler
{
    public function __construct(
        private readonly ApiResponse $apiResponse
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->apiResponse->success([
            'data' => 'Welcome, the API is working.'
        ]);
    }
}
