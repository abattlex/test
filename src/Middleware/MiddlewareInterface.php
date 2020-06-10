<?php

namespace App\Middleware;

use App\Request;

interface MiddlewareInterface
{
    public function process(Request $request);
}
