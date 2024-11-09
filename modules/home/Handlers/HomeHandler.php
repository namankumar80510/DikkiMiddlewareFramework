<?php

namespace Home\Handlers;

use Core\Libraries\ViewRenderer;
use Laminas\Diactoros\Response\HtmlResponse;

class HomeHandler
{

    public function __construct(
        private ViewRenderer $viewRenderer
    ) {}

    public function index()
    {
        return new HtmlResponse($this->viewRenderer->render('home::index'));
    }
}
