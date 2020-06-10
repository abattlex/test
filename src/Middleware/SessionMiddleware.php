<?php

namespace App\Middleware;

use App\Request;
use App\Session;

class SessionMiddleware implements MiddlewareInterface
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function process(Request $request)
    {
        return $request->setSession($this->session);
    }
}
