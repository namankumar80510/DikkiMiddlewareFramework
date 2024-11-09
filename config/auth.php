<?php

return [
    'auth_middleware_whitelist' => [
        '/auth/login',
        '/auth/register',
        '/api',
        '/api/*',
        '/git/*'
    ],

    'api_auth_login_middleware_whitelist' => [
        '/api/auth/login'
    ],

    'roles' => [
        'admin',
        'user'
    ],
];
