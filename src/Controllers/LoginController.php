<?php

namespace App\Controllers;

use App\Models\User;

class LoginController extends BaseController
{
    public function loginAction(array $params, string $method)
    {
        return $this->render('user', [
            ':title'    => 'Login',
            ':action'   => 'Login',
        ]);
    }

    public function registerAction(array $params, string $method)
    {
        if ($method === 'POST') {
            // TODO: validate params
            $user = $this->container->get(User::class);
            $user->save($params);
        }

        return $this->render('user', [
            ':title'    => 'Register',
            ':action'   => 'Register',
        ]);
    }
}
