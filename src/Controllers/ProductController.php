<?php

namespace App\Controllers;

use App\Forms\ProductUsersForm;
use App\Request;

class ProductController extends BaseController
{
    public function showUsersAction(Request $request)
    {
        $form = $this->container->get(ProductUsersForm::class);

        return $this->render('product/users', [
            ':form' => $form->render($request->getUriParams()),
        ]);
    }
}
