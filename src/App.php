<?php

namespace App;

class App
{
    protected FrontController $frontController;

    public function __construct(FrontController $frontController)
    {
        $this->frontController  = $frontController;
    }

    public function run()
    {
        echo $this->frontController->processRequest();
    }
}
