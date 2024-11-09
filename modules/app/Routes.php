<?php

/** @var \League\Route\Router $router */

/**
 * delete this file if you don't want to use APP module.
 */

use Laminas\Diactoros\Response\HtmlResponse;

$router->get('/', function () {
    return new HtmlResponse('Hello World');
});
