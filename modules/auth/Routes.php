<?php

/** @var \League\Route\Router $router */

// auth routes
$router->group('/auth', function ($router) {
    $router->get('/login', $this->container->get('auth_login_handler'));
    $router->get('/logout', $this->container->get('auth_logout_handler'));
});