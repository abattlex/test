<?php

namespace App\Controllers;

use App\Models\User;
use App\Request;

class LoginController extends BaseController
{
    public function loginAction(Request $request)
    {
        return $this->render('user', [
            ':title'    => 'Login',
            ':action'   => 'Login',
        ]);
    }

    public function registerAction(Request $request)
    {
        if ($request->isPOST()) {
            // TODO: validate params
            $user = $this->container->get(User::class);
            $user->save($request->getParams());
        }

        return $this->render('user', [
            ':title'    => 'Register',
            ':action'   => 'Register',
        ]);
    }
}
