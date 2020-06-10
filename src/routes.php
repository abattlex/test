<?php

return [
    '/'                 => [
        'controller'        => App\Controllers\IndexController::class,
        'action'            => 'indexAction',
    ],
    '/login'            => [
        'controller'        => App\Controllers\LoginController::class,
        'action'            => 'loginAction',
        'middleware'        => [App\Middleware\SessionMiddleware::class],
    ],
    '/register'         => [
        'controller'        => App\Controllers\LoginController::class,
        'action'            => 'registerAction',
        'middleware'        => [App\Middleware\SessionMiddleware::class],
    ],
    '/user/products'    => [
        'controller'        => App\Controllers\UserController::class,
        'action'            => 'showProductsAction',
        'middleware'        => [App\Middleware\SessionMiddleware::class, App\Middleware\AuthMiddleware::class],
    ],
];
