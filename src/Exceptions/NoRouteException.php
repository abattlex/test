<?php

namespace App\Exceptions;

use Throwable;

class NoRouteException extends \Exception
{
    public function __construct($route = "", $code = 0, Throwable $previous = null)
    {
        $message = "ROUTE [ $route ] DOES NOT EXIST";
        parent::__construct($message, $code, $previous);
    }
}
