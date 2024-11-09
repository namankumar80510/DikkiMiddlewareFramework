<?php

use Api\Handlers\WelcomeHandler as ApiWelcomeHandler;
use Auth\Libraries\SessionManager;
use Core\Libraries\ApiResponse;
use Core\Libraries\DatabaseManager;
use Core\Libraries\ViewRenderer;
use GuzzleHttp\Client;
use Home\Handlers\HomeHandler;
use League\Plates\Engine;

return [
    'services' => [
        // handlers
        # api handlers
        'api_welcome_handler' => [
            'class' => ApiWelcomeHandler::class,
            'arguments' => ['@api_response']
        ],

        # home handlers
        'home_welcome_handler' => [
            'class' => HomeHandler::class,
            'arguments' => ['@view_renderer']
        ],

        # auth handlers
        'auth_login_handler' => [
            'class' => \Auth\Handlers\LoginHandler::class,
            'arguments' => ['@view_renderer', '@session_manager']
        ],
        'auth_logout_handler' => [
            'class' => \Auth\Handlers\LogoutHandler::class,
            'arguments' => ['@session_manager']
        ],

        // libraries
        'api_response' => [
            'class' => ApiResponse::class,
            'arguments' => []
        ],
        'database_manager' => [
            'class' => DatabaseManager::class,
            'arguments' => []
        ],
        'guzzle_client' => [
            'class' => Client::class,
        ],
        'plates' => [
            'class' => Engine::class,
            'arguments' => []
        ],
        'session_manager' => [
            'class' => SessionManager::class,
            'arguments' => []
        ],
        'view_renderer' => [
            'class' => ViewRenderer::class,
            'arguments' => ['@plates']
        ],
    ]
];
