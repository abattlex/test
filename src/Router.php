<?php

namespace App;

class Router
{
    protected array $routes;

    public function __construct()
    {
        $this->routes = [];
        $routeMap = include SRC_DIR . DIRECTORY_SEPARATOR . 'routes.php';

        foreach ($routeMap as $route => $handler) {
            $route = self::clearRoute($route);
            $this->routes[$route] = [
                $handler['controller'],
                $handler['action'],
            ];
        }
    }

    public function set(string $route, string $controller, string $action): Router
    {
        $route = self::clearRoute($route);
        $this->routes[$route] = [$controller, $action];

        return $this;
    }

    public function get(string $route): ?array
    {
        $route = self::clearRoute($route);

        return $this->routes[$route] ?? null;
    }

    public static function clearRoute(string $route): string
    {
        return trim($route, '/ ');
    }
}
