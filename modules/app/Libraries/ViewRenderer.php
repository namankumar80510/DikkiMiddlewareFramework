<?php

namespace App\Libraries;

use League\Plates\Engine;

class ViewRenderer
{
    public function __construct(private Engine $engine)
    {
        foreach (config('modules.autoload') as $module) {
            $viewsPath = MODULES_PATH . $module . '/Views';
            if (file_exists($viewsPath)) {
                $this->engine->addFolder($module, $viewsPath);
            }
        }
    }

    public function render(string $template, array $data = []): string
    {
        return $this->engine->render($template, $data);
    }
}
