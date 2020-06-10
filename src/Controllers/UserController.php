<?php

namespace App\Controllers;

use App\Forms\UserProductsForm;
use App\Models\User;
use App\Request;

class UserController extends BaseController
{
    public function showProductsAction(Request $request)
    {
        if ($request->isPOST()) {
            $params         = $request->getParams();
            //$params['user'] = $request->getSession()->get(Session::KEY_USER_ID);
            $user = $this->container->get(User::class);
            $user->saveProducts($params);

        }

        $form = $this->container->get(UserProductsForm::class);

        return $this->render('user/products', [
            ':form' => $form->render(),
        ]);
    }
}
