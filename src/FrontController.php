<?php

namespace App;

class FrontController
{
    protected Router $router;
    protected SimpleContainer $container;
    protected Request $request;

    public function __construct(Router $router, SimpleContainer $container, Request $request)
    {
        $this->router       = $router;
        $this->container    = $container;
        $this->request      = $request;
    }

    public function processRequest()
    {
        $route                  = $_SERVER['REQUEST_URI'];
        [$controller, $action]  = $this->router->get($route);

        if (!$controller) {
            header("HTTP/1.0 404 Not Found");
            return '404 Not Found';
        }

        $controller = $this->container->get($controller);

        return $controller->$action($this->request);
    }
}
