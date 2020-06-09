<?php

namespace App;

use App\Controllers\IndexController;
use App\Controllers\LoginController;
use App\Exceptions\NoRouteException;

class Router
{
    const ROUTES = [
        ''          => [IndexController::class, 'indexAction'],
        'login'     => [LoginController::class, 'loginAction'],
        'register'  => [LoginController::class, 'registerAction'],
    ];

    public function handle(): array
    {
        $route  = trim($_SERVER['REQUEST_URI'], '/ ');
        if (!isset(self::ROUTES[$route])) {
            throw new NoRouteException($route);
        }

        // TODO: move to request class
        return [
            'handler'   => self::ROUTES[$route],
            'method'    => $_SERVER['REQUEST_METHOD'],
            'params'    => $_REQUEST,
        ];
    }
}
