<?php

/** @var \League\Route\Router $router */

$router->get('/', [$this->container->get('home_handler'), 'index']);
