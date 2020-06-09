<?php

namespace App\Controllers;

use App\SimpleContainer;

abstract class BaseController
{
    protected SimpleContainer $container;

    public function __construct(SimpleContainer $container)
    {
        $this->container = $container;
    }

    public function render(string $templateName, array $params = []): string
    {
        $template = file_get_contents(TEMPLATE_DIR . DIRECTORY_SEPARATOR . $templateName . ".html");

        return str_replace(
            array_map(fn (string $item) => "{{ $item }}", array_keys($params)),
            array_values($params),
            $template
        );
    }
}
