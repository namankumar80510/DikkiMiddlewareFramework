<?php

return [
    'name' => 'Dikki Middleware',
    'version' => '0.0.1',
    'url' => 'https://example.com',

    // Global middlewares; loaded before every route
    'middlewares' => [
        new \App\Middlewares\CorsMiddleware,
        // new \Auth\Middlewares\AuthMiddleware() # remove it if you want whole site to be private
    ]
];
