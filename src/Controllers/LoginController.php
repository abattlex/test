<?php

namespace App\Controllers;

use App\Models\User;
use App\Request;
use App\Session;

class LoginController extends BaseController
{
    public function loginAction(Request $request)
    {
        if ($request->isPOST()) {
            $user = $this->container->get(User::class);
            $userData = $user->findOne($request->getParams());

            if (!$userData) {
                $this->redirect('/');
            }

            $this->startSession($request, $userData);
            $this->redirect('/user/products');
        }

        return $this->render('login', [
            ':title'    => 'Login',
            ':action'   => 'Login',
        ]);
    }

    public function registerAction(Request $request)
    {
        if ($request->isPOST()) {
            // TODO: validate params
            $user = $this->container->get(User::class);
            if ($userData = $user->save($request->getParams())) {
                $this->startSession($request, $userData);
                $this->redirect('/user/products');
            }
        }

        return $this->render('login', [
            ':title'    => 'Register',
            ':action'   => 'Register',
        ]);
    }

    protected function startSession(Request $request, array $userData)
    {
        $request->getSession()
            ->set(Session::KEY_USER_NAME, $userData['name'])
            ->set(Session::KEY_USER_ID, $userData['id']);
    }
}
