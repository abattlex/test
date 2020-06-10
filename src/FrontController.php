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
        $route                              = $_SERVER['REQUEST_URI'];
        [$controller, $action, $middleware] = $this->router->get($route);

        if ($middleware) {
            foreach ($middleware as $class) {
                $mid = $this->container->get($class);
                $this->request = $mid->process($this->request);
            }
        }

        if (!$controller) {
            Response::notFound();
        }

        $controller = $this->container->get($controller);

        return $controller->$action($this->request);
    }
}
