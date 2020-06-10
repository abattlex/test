<?php

namespace App\Middleware;

use App\Request;
use App\Response;
use App\Session;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request)
    {
        $session    = $request->getSession();
        $userId     = $session->get(Session::KEY_USER_ID);
        $userName   = $session->get(Session::KEY_USER_NAME);

        if ($userId && $userName) {
            return $request;
        }

        Response::redirect('/', Response::HTTP_CODE_UNAUTHORIZED, '401 Not Authorized');
    }
}
