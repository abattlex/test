<?php

namespace App;

use App\Exceptions\NoRouteException;

class App
{
    protected Router $router;
    protected SimpleContainer $container;

    public function __construct(Router $router, SimpleContainer $container)
    {
        $this->container    = $container;
        $this->router       = $router;
    }

    public function run()
    {
        echo $this->processAction();
    }

    // TODO: move to front controller
    protected function processAction()
    {
        try {
            $request = $this->router->handle();
            [$controller, $action] = $request['handler'];
        } catch (NoRouteException $e) {
            header("HTTP/1.0 404 Not Found");
            return '404 Not Found';
        }
        // TODO: need to use factory
        $controller = new $controller($this->container);
        return $controller->$action($request['params'], $request['method']);
    }
}
