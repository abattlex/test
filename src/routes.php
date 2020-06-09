<?php

return [
    '/'          => [
        'controller'    => App\Controllers\IndexController::class,
        'action'        => 'indexAction',
    ],
    '/login'     => [
        'controller'    => App\Controllers\LoginController::class,
        'action'        => 'loginAction',
    ],
    '/register'  => [
        'controller'    => App\Controllers\LoginController::class,
        'action'        => 'registerAction',
    ],
];
