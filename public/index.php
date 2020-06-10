<?php

define('BASE_DIR', dirname(__DIR__));
define('SRC_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'src');
define('VENDOR_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'vendor');
define('TEMPLATE_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'templates');

include VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

$container = new \App\SimpleContainer();

try {
    $app = $container->get(\App\App::class);
    $app->run();
} catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo 'Something went wrong';
    die();
}
