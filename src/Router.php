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
                $handler['middleware'] ?? null,
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
        $route  = self::clearRoute($route);
        $result = $this->routes[$route] ?? null;
        if (!$result) {
            foreach ($this->routes as $key => $routeData) {
                $pattern = "#^$key$#";
                if (preg_match($pattern, $route, $params)) {
                    $uriParams = [];
                    foreach ($params as $paramKey => $paramValue) {
                        if (!is_int($paramKey)) {
                            $uriParams[$paramKey] = $paramValue;
                        }
                    }
                    $routeData[] = $uriParams;
                    $result = $routeData;
                    break;
                }
            }
        }

        return $result;
    }

    public static function clearRoute(string $route): string
    {
        return trim($route, '/ ');
    }
}
