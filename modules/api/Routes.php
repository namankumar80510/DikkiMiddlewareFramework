<?php

/** @var \League\Route\Router $router */

// api routes
$router->group('/api/v1', function ($router) {
    $router->get('/', $this->container->get('api_welcome_handler'));
})->middleware(new \App\Middlewares\ApiAuthMiddleware); // api route specific middleware [for authentication]
