<?php

namespace App\Exceptions;

use Throwable;

class NoConfig extends \Exception
{
    public function __construct($configFile = "", $code = 0, Throwable $previous = null)
    {
        $message = "CONFIG FILE [ $configFile ] NOT FOUND";
        parent::__construct($message, $code, $previous);
    }
}
