<?php

define('BASE_DIR', dirname(__DIR__));
define('SRC_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'src');
define('VENDOR_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'vendor');
define('TEMPLATE_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'templates');

include VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

$container = new \App\SimpleContainer();

$app = $container->get(\App\App::class);

$app->run();
