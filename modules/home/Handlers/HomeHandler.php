<?php

namespace Home\Handlers;

use Laminas\Diactoros\Response\HtmlResponse;

class HomeHandler
{
    public function index()
    {
        return new HtmlResponse('Home');
    }
}
